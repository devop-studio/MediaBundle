<?php

namespace MediaBundle\Twig;

use MediaBundle\Model\Media;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MediaExtension extends \Twig_Extension
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * 
     * @return array
     */
    public function getFunctions()
    {
        return [
            'media' => new \Twig_SimpleFunction('media', [$this, 'generateURL'])
        ];
    }

    /**
     * 
     * @param Media $media
     * 
     * @return string
     */
    public function generateURL(Media $media)
    {

        /* @var $requestStack \Symfony\Component\HttpFoundation\RequestStack */
        $requestStack = $this->container->get('request_stack');

        return sprintf('%s/%s/%s/%s', $requestStack->getCurrentRequest()->getBasePath(), $this->container->getParameter('media.upload_path'), $media->getFormat(), $media->getFilename()
        );
    }

}
