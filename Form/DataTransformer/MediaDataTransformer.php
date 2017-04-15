<?php

namespace MediaBundle\Form\DataTransformer;

use MediaBundle\Model\Media;
use MediaBundle\Manager\MediaManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    
    public function reverseTransform($value)
    {
        if ($value instanceof UploadedFile) {
            return $this->manager->upload($value)->save($value);
        } else if ($value instanceof Media) {
            return $value;
        }
        return null;
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
