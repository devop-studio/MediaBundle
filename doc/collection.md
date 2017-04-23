## Collection widget

### Create OneToMany relation with Entity, with field for file

```
<?php
// src/entity/Entity

class Entity
{
    ...
    /**
     *
     * @var ArticleHasImages[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\MainBundle\Entity\EntityHasImage", mappedBy="entity", orphanRemoval=true, cascade={"persist"})
     */
    protected $images;
    ...
}
```

and other entity

```
<?php
// src/entity/EntityHasImage

class EntityHasImage
{
    ...
    /**
     *
     * @var Entity
     *
     * @ORM\ManyToOne(targetEntity="\MainBundle\Entity\Entity", inversedBy="images", cascade={"persist"})
     */
    protected $article;
    ...
}
```

Then, created two form types, one for Entity, and other for other entity EntityHasImage

```
<?php
// src/Form/Type/Entity

use Symfony\Component\Form\AbstractType;
use MediaBundle\Form\Type\MediaCollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Form extends AbstractType
{
    ...
    ->add('images', MediaCollectionType::class, [
        'required' => false,
        'allow_add' => true,
        'allow_delete' => true,
        'delete_empty' => true,
        'entry_type' => ArticleHasImagesType::class
    ])
    ...
}
```

When form is submitted, you must presave your collection, with something like that

```
<?php
// src/Controller/MediaController.php

class MediaController
{
        ...
        if ($form->isValid()) {

            foreach ($form->get('images')->getData() AS /* @var $image \MainBundle\Entity\EntityHasImage */ $image) {
                $image->setEntity($form->getData());
            }

            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            // other success callbacks
        }
        ...
}
```

and voala ~
