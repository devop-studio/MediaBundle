<?php

namespace MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class MediaBundle extends Bundle
{

    /**
     * 
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver([__DIR__ . '/Resources/config/doctrine-mapping' => 'MediaBundle\Model']));
    }

}
