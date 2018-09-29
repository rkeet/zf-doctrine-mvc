<?php

namespace Keet\Mvc\Module;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class AbstractModule
 *
 * @package Keet\Mvc\Module
 *
 *          Easily use this class to load your modules. The assumption this class does is that you're following the
 *          Zend Framework 3 standard of having your Module.php inside of your src/ folder.
 */
abstract class AbstractModule implements ConfigProviderInterface, AutoloaderProviderInterface
{
    /**
     * @var String Path of current module
     */
    protected $path;

    /**
     * @var String Namespace of current module
     */
    protected $namespace;

    /**
     * This is to be called by descendant classes with:
     * parent::__construct(__DIR__, __NAMESPACE__)
     *
     * @param $path      string Module path
     * @param $namespace string Module namespace
     */
    public function __construct($path, $namespace)
    {
        $this->path = $path;
        $this->namespace = $namespace;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = [];

        $path = $this->path
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . '*.php';

        foreach (glob($path) as $filename) {
            $config = array_merge_recursive($config, include $filename);
        }

        return $config;
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    $this->namespace => $this->path . DIRECTORY_SEPARATOR . 'src',
                ],
            ],
        ];
    }
}