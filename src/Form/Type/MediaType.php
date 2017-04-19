<?php

namespace MediaBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use MediaBundle\Manager\MediaManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use MediaBundle\Form\DataTransformer\MediaDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MediaType extends AbstractType
{

    /**
     *
     * @var MediaManager
     */
    private $manager;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * 
     * @param MediaManager $manager
     * @param EntityManager $entityManager
     */
    public function __construct(MediaManager $manager, EntityManager $entityManager)
    {
        $this->manager = $manager;
        $this->entityManager = $entityManager;
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

        $builder->addModelTransformer(new MediaDataTransformer($this->manager, $this->entityManager, $options));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            if ($event->getData()) {
                $event->getForm()->add('fileRemove', CheckboxType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'media.form.label.remove',
                ]);
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) use ($options) {
            if ($event->getForm()->has('fileRemove') && $event->getForm()->get('fileRemove')->getData()) {
                $this->manager->delete($event->getData(), $options);
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
