<?php

namespace Keet\Mvc;

use Keet\Mvc\Factory\TranslatorPluginFactory;
use Keet\Mvc\Plugin\TranslatorPlugin;
use Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;

return [
    'controller_plugins' => [
        'aliases'   => [
            'translator' => TranslatorPlugin::class,
        ],
        'factories' => [
            TranslatorPlugin::class => TranslatorPluginFactory::class,
        ],
    ],
    'router'             => [
        'router_class' => TranslatorAwareTreeRouteStack::class,
        //        'translator_text_domain' => 'routing', // TODO make sure that routes can/will be translated
    ],
];