<?php

namespace MediaBundle\Form\Type;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use MediaBundle\Manager\MediaManagerInterface;
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
     * @var MediaManagerInterface
     */
    private $manager;

    /**
     *
     * @var DataTransformerInterface
     */
    private $dataTransformer;

    /**
     * 
     * @param MediaManagerInterface $manager
     * @param DataTransformerInterface $dataTransformer
     */
    public function __construct(MediaManagerInterface $manager, DataTransformerInterface $dataTransformer)
    {
        $this->manager = $manager;
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
                ->add('file', FileType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'file',
                        'data-show-upload' => 'false',
                        'data-show-preview' => 'false'
        ]]);

        $this->manager->setOptions($options);

        $builder->addModelTransformer($this->dataTransformer);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            if ($event->getData()) {
                $event->getForm()->add('fileRemove', CheckboxType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'media.form.label.remove',
                ]);
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            if ($event->getForm()->has('fileRemove') && $event->getForm()->get('fileRemove')->getData()) {
                $this->manager->delete($event->getData());
                $event->setData(null);
            }
        });
    }

    /**
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'keep_existing' => false,
            'translation_domain' => 'MediaBundle'
        ]);
        $resolver->setRequired(['format', 'data_class']);
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
