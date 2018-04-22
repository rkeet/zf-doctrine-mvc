<?php

namespace Keet\Mvc\Entity;

use Doctrine\ORM\Mapping as ORM;
use Keet\Mvc\Event\DoctrineEvent;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventInterface as Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Event
     */
    protected $event;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * @var null|string|string[]
     */
    protected $eventIdentifier;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the event manager instance used by this context
     *
     * @param  EventManagerInterface $events
     * @return AbstractEntity
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $className = get_class($this);

        $nsPos = strpos($className, '\\') ?: 0;
        $events->setIdentifiers(array_merge(
            [
                __CLASS__,
                $className,
                substr($className, 0, $nsPos)
            ],
            array_values(class_implements($className)),
            (array) $this->eventIdentifier
        ));

        $this->events = $events;

        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->events) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }

    /**
     * Set an event to use during dispatch
     *
     * By default, will re-cast to MvcEvent if another event type is provided.
     *
     * @param  Event $e
     * @return void
     */
    public function setEvent(Event $e)
    {
        if (!$e instanceof DoctrineEvent) {
            $eventParams = $e->getParams();
            $e = new DoctrineEvent();
            $e->setParams($eventParams);
            unset($eventParams);
        }
        $this->event = $e;
    }

    /**
     * Get the attached event
     *
     * Will create a new MvcEvent if none provided.
     *
     * @return DoctrineEvent|EventInterface
     */
    public function getEvent()
    {
        if (!$this->event) {
            $this->setEvent(new DoctrineEvent());
        }

        return $this->event;
    }

    /**
     * Gets an array copy
     */
    public function getArrayCopy()
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            // Skip relations
            if (is_object($value)) {
                unset($values[$property]);
            }
        }

        return $values;
    }

    /**
     * Maps the specified data to the properties of this object
     *
     * @param array $data
     */
    public function exchangeArray($data)
    {
        foreach ($data as $property => $value) {
            if (isset($this->$property)) {
                $method = 'set' . ucfirst($property);
                $this->$method($value);
            }
        }
    }

    /**
     * Gets associations
     */
    public function getAssociations()
    {
        $values = get_object_vars($this);
        foreach ($values as $property => $value) {
            // Skip scalar values
            if (!is_object($value)) {
                unset($values[$property]);
            }
        }

        return $values;
    }
}