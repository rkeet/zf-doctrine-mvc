<?php

namespace Keet\Mvc\Traits;

trait CreatedAtTrait
{
    /**
     * @var \DateTime
     * @Doctrine\ORM\Mapping\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt() : ?\DateTime // Allow 'null' return for Doctrine compatibility
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt) : self
    {
        if (empty($this->getCreatedAt())) {
            $this->createdAt = $createdAt;
        }

        return $this;
    }

    /**
     * @Doctrine\ORM\Mapping\PrePersist()
     *
     * @return CreatedAtTrait
     * @throws \Exception
     */
    public function prePersistCreatedAt() : self
    {
        if (empty($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime('now'));
        }

        return $this;
    }
}