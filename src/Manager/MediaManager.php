<?php

namespace MediaBundle\Manager;

use MediaBundle\Model\Media;
use Doctrine\ORM\EntityManager;
use MediaBundle\Manager\MediaManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaManager implements MediaManagerInterface
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var string
     */
    private $kernelRootDir;
    
    /**
     *
     * @var string
     */
    private $uploadPath;
    
    /**
     * 
     * @param EntityManager $entityManager
     * @param string $kernelRootDir
     * @param string $uploadPath
     */
    public function __construct(EntityManager $entityManager, $kernelRootDir, $uploadPath)
    {
        $this->entityManager = $entityManager;
        $this->kernelRootDir = $kernelRootDir;
        $this->uploadPath = $uploadPath;
    }

    /**
     * 
     * @param UploadedFile $file
     * @param string $directory
     * 
     * @return string
     */
    public function generateName(UploadedFile $file, $directory)
    {
        $extension = $file->guessExtension();
        do {
            $filename = md5(uniqid()) . '.' . $extension;
            if (file_exists($directory . DIRECTORY_SEPARATOR . $filename)) {
                $filename = null;
            }
        } while (is_null($filename));
        return $filename;
    }

    /**
     * 
     * @param UploadedFile $file
     * 
     * @return array
     */
    public function updateMetaData(UploadedFile $file)
    {
        return [
            'filename' => $file->getClientOriginalName(),
            'filesize' => $file->getClientSize(),
            'filetype' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension()
        ];
    }

    /**
     * 
     * @param Media $media
     * @param array $options
     * 
     * @return Media
     */
    public function save(Media $media, array $options = [])
    {

        if (!$media->getFile() instanceof UploadedFile) {
            return $media->getId() ? $media : null;
        }

        $directory = implode(DIRECTORY_SEPARATOR, array($this->kernelRootDir, '..', 'web', $this->uploadPath, $options['format']));

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $this->generateName($media->getFile(), $directory);

        $media->getFile()->move($directory, $filename);

        if ($media->getId()) {
            if (!$options['keep_existing']) {
                $this->delete($media);
                $entity = $media;
            } else {
                $entity = new $options['data_class'];
            }
        } else {
            $entity = new $options['data_class'];
        }

        $entity->setFilename($filename);
        $entity->setFormat($options['format']);
        $entity->setMetadata($this->updateMetaData($media->getFile()));

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * 
     * @param Media $media
     * @param array $options
     * @param boolean $force
     */
    public function delete(Media $media, array $options = [], $force = false)
    {

        $directory = implode(DIRECTORY_SEPARATOR, array($this->kernelRootDir, '..', 'web', $this->uploadPath, $options['format']));

        if (file_exists($directory . DIRECTORY_SEPARATOR . $media->getFilename())) {
            unlink($directory . DIRECTORY_SEPARATOR . $media->getFilename());
        }
        
        $this->entityManager->remove($media);
        if ($force) {
            $this->entityManager->flush();
        }
    }

}
