<?php

namespace Keet\Mvc\Factory;

use Exception;
use Interop\Container\ContainerInterface;
use Keet\Mvc\Plugin\TranslatorPlugin;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TranslatorPluginFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (!$container->has('translator')) {

            throw new Exception('Zend I18n Translator not configured.');
        }

        /** @var TranslatorInterface $translator */
        $translator = $container->get('translator');

        return new TranslatorPlugin($translator);
    }
}