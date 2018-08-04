<?php

namespace Keet\Mvc\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for instantiating classes requiring the Doctrine (default) EntityManager
 *
 * The InvokableEntityManagerFactory can be used for any class that:
 *
 * - requires an ObjectManager (EntityManager) as the first parameter;
 * - accepts a single array of arguments via the constructor as the second parameter.
 */
final class InvokableEntityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $objectManager = $container->get(EntityManager::class);

        return (null === $options) ? new $requestedName($objectManager) : new $requestedName($objectManager, $options);
    }
}