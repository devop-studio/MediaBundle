<?php

namespace MediaBundle\Manager;

use MediaBundle\Model\Media;

interface MediaManagerInterface
{

    /**
     * 
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * 
     * @param Media $media
     */
    public function save(Media $media);
    
    /**
     * 
     * @param Media $media
     */
    public function delete(Media $media);
}
