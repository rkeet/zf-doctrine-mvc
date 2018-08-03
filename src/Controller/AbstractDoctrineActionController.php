<?php

namespace Keet\Mvc\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Keet\Mvc\Entity\AbstractEntity;
use Zend\Di\Exception\ClassNotFoundException;

abstract class AbstractDoctrineActionController extends AbstractActionController
{
    /**
     * @var ObjectManager|EntityManager
     */
    protected $objectManager;

    /**
     * AbstractDoctrineController constructor.
     *
     * @param ObjectManager|EntityManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * Tests if a received class name is in fact a Doctrine Entity
     *
     * Based on @link https://stackoverflow.com/a/27121978/1155833
     *
     * @param string $classFQCN
     *
     * @return boolean
     * @throws EntityNotFoundException
     */
    function isEntity(string $classFQCN) : bool
    {
        if ( ! class_exists($classFQCN)) {

            throw new ClassNotFoundException(sprintf('Given class FQCN "%s" does not exist.', $classFQCN));
        }

        if ( ! is_object($classFQCN)) {

            throw new EntityNotFoundException(sprintf('Given class "%s" is not a Doctrine Entity.', $classFQCN));
        }

        return ! $this->getObjectManager()
                      ->getMetadataFactory()
                      ->isTransient(ClassUtils::getClass($classFQCN));
    }

    /**
     * Gets the route parameters based on generic naming
     * i.e. -> Giving a parameter ['id'] will cause $entity->getId() to be executed and returned as ['id' => 123]
     *
     * @param AbstractEntity $entity
     * @param array          $routeParams
     *
     * @return array
     */
    public function getRouteParams(AbstractEntity $entity, array $routeParams = [])
    {
        if (count($routeParams) === 0) {

            return [];
        }

        $params = [];
        foreach ($routeParams as $param) {
            if ( ! method_exists($entity, 'get' . ucfirst($param))) {

                trigger_error(
                    'Function "get' . ucfirst($param) . '" does not exist on "' . get_class($entity) . '". Skipping.'
                );
                continue;
            }

            $params[$param] = $entity->{'get' . ucfirst($param)}();
        }

        return $params;
    }

    /**
     * @return ObjectManager|EntityManager
     */
    public function getObjectManager() : ObjectManager
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager|EntityManager $objectManager
     *
     * @return AbstractDoctrineActionController
     */
    public function setObjectManager(ObjectManager $objectManager) : AbstractDoctrineActionController
    {
        $this->objectManager = $objectManager;
        return $this;
    }
}