<?php

namespace MediaBundle\Twig;

use MediaBundle\Model\Media;
use Symfony\Component\HttpFoundation\RequestStack;

class MediaExtension extends \Twig_Extension
{

    /**
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     *
     * @var string
     */
    private $uploadPath;

    /**
     * 
     * @param RequestStack $requestStack
     * @param string $uploadPath
     */
    public function __construct(RequestStack $requestStack, $uploadPath)
    {
        $this->requestStack = $requestStack;
        $this->uploadPath = $uploadPath;
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
        return sprintf('%s/%s/%s/%s', $this->requestStack->getCurrentRequest()->getBasePath(), $this->uploadPath, $media->getFormat(), $media->getFilename());
    }

}
