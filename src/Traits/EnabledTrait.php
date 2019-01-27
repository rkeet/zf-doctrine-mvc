<?php

namespace Keet\Mvc\Traits;

trait EnabledTrait
{
    /**
     * Defaults to true.
     *
     * @var bool
     * @Doctrine\ORM\Mapping\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $enabled = true;

    /**
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

}