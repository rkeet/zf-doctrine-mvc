<?php

namespace Keet\Mvc\Doctrine;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * Class UtcDateTimeType
 *
 * @package Keet\Mvc\Doctrine
 *
 * If loaded, it will convert any received DateTime object to have the UTC timezone and convert the date and time
 * accordingly. This makes any date and time stored in the database uniformly the same.
 *
 * Note: If you use this, and you support more than 1 timezone (e.g. User preference based), make sure to convert
 *       back to original timezone for viewing/editing.
 */
class UtcDateTimeType extends DateTimeType
{
    /**
     * @var DateTimeZone
     */
    protected $utc;

    /**
     * @param                  $value
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        if ($value instanceof DateTime) {
            $value->setTimezone($this->getUtc());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return DateTime
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : DateTime
    {
        if ($value === null || $value instanceof \DateTime) {

            return $value;
        }

        if ( ! $this->getUtc() instanceof \DateTimeZone) {

            $this->setUtc(new \DateTimeZone('UTC'));
        }

        /** @var DateTime $converted */
        $converted = DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            $this->getUtc()
        );

        if ( ! $converted) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return $converted;
    }

    /**
     * @return DateTimeZone
     */
    public function getUtc()
    {
        if (is_null($this->utc)) {
            $this->setUtc((new \DateTimeZone('utc')));
        }

        return $this->utc;
    }

    /**
     * @param DateTimeZone $utc
     *
     * @return UtcDateTimeType
     */
    public function setUtc(DateTimeZone $utc) : UtcDateTimeType
    {
        $this->utc = $utc;

        return $this;
    }
}