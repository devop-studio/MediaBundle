<?php

namespace MediaBundle\Manager;

use MediaBundle\Model\Media;

interface MediaManagerInterface
{

    /**
     * 
     * @param Media $media
     * @param array $options
     */
    public function save(Media $media, array $options = []);
    
    /**
     * 
     * @param Media $media
     * @param array $options
     * @param boolean $force
     */
    public function delete(Media $media, array $options = [], $force = false);
}
