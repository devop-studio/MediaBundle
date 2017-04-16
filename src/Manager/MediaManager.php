<?php

namespace MediaBundle\Manager;

use MediaBundle\Model\Media;
use Doctrine\ORM\EntityManager;
use MediaBundle\Manager\MediaManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MediaManager implements MediaManagerInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var array
     */
    private $options = [];

    /**
     * 
     * @param ContainerInterface $container
     * @param EntityManager $entityManager
     */
    public function __construct(ContainerInterface $container, EntityManager $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
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
     * 
     * @return $this
     */
    public function save(Media $media)
    {

        if (!$media->getFile() instanceof UploadedFile) {
            return null;
        }

        $directory = implode(DIRECTORY_SEPARATOR, [
            $this->container->getParameter('kernel.root_dir'),
            '..' . DIRECTORY_SEPARATOR . 'web',
            $this->container->getParameter('media.upload_path'),
            $this->options['format']
        ]);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $this->generateName($media->getFile(), $directory);

        $media->getFile()->move($directory, $filename);

        if ($media->getId()) {
            if (!$this->options['keep_existing']) {
                $this->delete($media);
                $entity = $media;
            } else {
                $entity = new $this->options['data_class'];
            }
        } else {
            $entity = new $this->options['data_class'];
        }

        $entity->setFilename($filename);
        $entity->setFormat($this->options['format']);
        $entity->setMetadata($this->updateMetaData($media->getFile()));

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function delete(Media $media, $force = false)
    {

        $directory = implode(DIRECTORY_SEPARATOR, [
            $this->container->getParameter('kernel.root_dir'),
            '..' . DIRECTORY_SEPARATOR . 'web',
            $this->container->getParameter('media.upload_path'),
            $this->options['format']
        ]);

        if (file_exists($directory . DIRECTORY_SEPARATOR . $media->getFilename())) {
            unlink($directory . DIRECTORY_SEPARATOR . $media->getFilename());
        }
        
        $this->entityManager->remove($media);
        if ($force) {
            $this->entityManager->flush();
        }
    }

}
