<?php

namespace MediaBundle\Tests;

if (!class_exists('\PHPUnit\Framework\TestCase') && class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testConfigurationDefault()
    {
        
        $processor = new \Symfony\Component\Config\Definition\Processor();
        $config = $processor->processConfiguration(new \MediaBundle\DependencyInjection\Configuration(), array());

        $this->assertEquals('orm', $config['db_driver']);
        $this->assertEquals('uploads', $config['upload_path']);
    }
    
    public function testConfigurationCustom()
    {
        $processor = new \Symfony\Component\Config\Definition\Processor();
        $config = $processor->processConfiguration(new \MediaBundle\DependencyInjection\Configuration(), array(
            'media' => array(
                'db_driver' => 'orm',
                'upload_path' => 'custom_uploads'
            )
        ));
        
        $this->assertEquals('orm', $config['db_driver']);
        $this->assertEquals('custom_uploads', $config['upload_path']);
    }

}
