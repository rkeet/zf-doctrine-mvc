<?php

namespace Keet\Mvc;

use Doctrine\ORM\EntityManager;
use Keet\Mvc\Module\AbstractModule;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
    public function __construct()
    {
        parent::__construct(__DIR__, __NAMESPACE__);
    }
}