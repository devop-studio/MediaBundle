<?php

namespace MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MediaType extends AbstractType
{

    /**
     *
     * @var DataTransformerInterface 
     */
    private $dataTransformer;
    
    /**
     * 
     * @param DataTransformerInterface $dataTransformer
     */
    public function __construct(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }
    
    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('file', FileType::class, array(
                    'label' => false,
                    'required' => false,
                    'attr' => array(
                        'class' => 'file',
                        'data-show-upload' => 'false',
                        'data-show-preview' => 'false',
                    )
                ))
                ->add('remove', CheckboxType::class, array(
                    'mapped' => false,
                    'required' => false
        ));
        
        $builder->get('file')->addModelTransformer($this->dataTransformer);
    }

    /**
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    /**
     * 
     * @return string
     */
    public function getParent()
    {
        return FormType::class;
    }

}
