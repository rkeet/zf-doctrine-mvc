<?php

namespace Keet\Mvc;

use Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;

return [
    'router' => [
        'router_class'           => TranslatorAwareTreeRouteStack::class,
//        'translator_text_domain' => 'routing', // TODO make sure that routes can/will be translated
    ],
];