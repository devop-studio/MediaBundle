<?php

namespace MediaBundle\Manager;

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
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function upload(UploadedFile $file)
    {
        
        return $this;
    }

    /**
     * 
     * @param UploadedFile $file
     * 
     * @return $this
     */
    public function save(UploadedFile $file)
    {
        return $this;
    }

}
