<?php

namespace MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MediaCollectionType extends AbstractType
{

    /**
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('translation_domain', 'MediaBundle');
    }

    /**
     * 
     * @return string
     */
    public function getParent()
    {
        return CollectionType::class;
    }
    
}
