<?php

namespace MediaBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

abstract class Media
{

    /**
     *
     * @var int
     */
    protected $id;
    
    /**
     *
     * @var File
     */
    protected $file;
    
    /**
     *
     * @var string
     */
    protected $filename;
    
    /**
     *
     * @var string
     */
    protected $format;

    /**
     *
     * @var array
     */
    protected $metadata;

    /**
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @param File $file
     * 
     * @return $this
     */
    public function setFile(File $file)
    {
        $this->file = $file;
        
        return $this;
    }
    
    /**
     * 
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
    
    public function prePersist()
    {
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
    }
    
    /**
     * Set filename
     *
     * @param filename $filename
     *
     * @return Media
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return Media
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set metadata
     *
     * @param array $metadata
     *
     * @return Media
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Media
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Media
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
