<?php

namespace MediaBundle\Form\DataTransformer;

use MediaBundle\Model\Media;
use Doctrine\ORM\EntityManager;
use MediaBundle\Manager\MediaManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
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
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     *
     * @var array
     */
    private $options = array();
    
    /**
     * 
     * @param MediaManagerInterface $manager
     * @param EntityManager $entityManager
     * @param array $options
     */
    public function __construct(MediaManagerInterface $manager, EntityManager $entityManager, $options = [])
    {
        $this->manager = $manager;
        $this->entityManager = $entityManager;
        $this->options = $options;
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
            return $this->manager->save($value, $this->options);
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
