<?php

namespace Keet\Mvc\Traits;

trait ModifiedAtTrait
{
    /**
     * @var \DateTime
     * @Doctrine\ORM\Mapping\Column(name="modified_at", type="datetime", nullable=false)
     */
    protected $modifiedAt;

    /**
     * @return \DateTime
     */
    public function getModifiedAt() : ?\DateTime
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $modifiedAt
     *
     * @return $this
     */
    public function setModifiedAt(\DateTime $modifiedAt) : self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Note: PreFlush gets triggered on a whole "chain" of Entities. See comment in link
     *
     * @link https://stackoverflow.com/a/28902531/1155833
     *
     * @Doctrine\ORM\Mapping\PreFlush()
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     *
     * @return $this
     * @throws \Exception
     */
    public function preFlushModifiedAt(\Doctrine\ORM\Event\PreFlushEventArgs $args) : self
    {
        if (is_null($this->getModifiedAt())) {
            $this->setModifiedAt(new \DateTime('now'));
        }

        return $this;
    }

    /**
     * Note: This function gets triggered only if the Entity ($this) has changes. See docs:
     *
     * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#preupdate
     *
     * -----
     * PreUpdate is the most restrictive to use event, since it is called right before an update statement is
     * called for an entity inside the EntityManager#flush() method. Note that this event is not triggered
     * when the computed changeset is empty.
     * -----
     *
     * @Doctrine\ORM\Mapping\PreUpdate()
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     *
     * @return $this
     * @throws \Exception
     */
    public function preUpdateModifiedAt(\Doctrine\ORM\Event\PreUpdateEventArgs $args) : self
    {
        $this->setModifiedAt(new \DateTime('now'));

        return $this;
    }
}