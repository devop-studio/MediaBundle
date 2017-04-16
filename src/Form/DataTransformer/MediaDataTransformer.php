<?php

namespace MediaBundle\Form\DataTransformer;

use MediaBundle\Model\Media;
use MediaBundle\Manager\MediaManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaDataTransformer implements DataTransformerInterface
{

    /**
     *
     * @var MediaManagerInterface
     */
    private $manager;

    /**
     * 
     * @param MediaManagerInterface $manager
     */
    public function __construct(MediaManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 
     * @param Media|array|null $value
     * 
     * @return Media|null
     * 
     * @throws TransformationFailedException
     */
    public function reverseTransform($value)
    {
        if ($value instanceof Media) {
            return $this->manager->save($value);
        } else if (is_null($value)) {
            return $value;
        }
        throw new TransformationFailedException();
    }

    /**
     * 
     * @param string|null $value
     * 
     * @return string|null
     */
    public function transform($value)
    {
        return $value;
    }

}
