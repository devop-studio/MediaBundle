<?php

namespace MediaBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface MediaManagerInterface
{

    /**
     * 
     * @param UploadedFile $file
     */
    public function upload(UploadedFile $file);

    /**
     * 
     * @param UploadedFile $file
     */
    public function save(UploadedFile $file);
}
