<?php

namespace Keet\Mvc\Traits;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * If set, the entity is 'deleted', though technically still present. Use together with
 * '\Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter' filter for Doctrine, like so:
 *
 * 'doctrine'           => [
 *     'configuration'            => [
 *         'orm_default' => [
 *             'filters' => [
 *                 'soft-deleteable' => SoftDeleteableFilter::class,
 *             ],
 *         ],
 *     ],
 * ],
 *
 * NOTE: Do not forget to give the entity the following Annotation (no space, include "@"):
 * @ Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * and include the following namespace, with alias:
 * use Gedmo\Mapping\Annotation as Gedmo;
 */
trait GedmoDeletedAtTrait
{
    use SoftDeleteableEntity;

    /**
     * Note: overrides Annotation and type hint, else it's the same as the original
     *
     * @var \DateTime|null
     * @Doctrine\ORM\Mapping\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;
}