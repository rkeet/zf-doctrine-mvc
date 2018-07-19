<?php

namespace Keet\Mvc;

use Keet\Mvc\Module\AbstractModule;

class Module extends AbstractModule
{
    public function __construct()
    {
        parent::__construct(__DIR__, __NAMESPACE__);
    }
}