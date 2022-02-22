<?php

namespace Braspag\Helpers;

class DateTimeHelper
{
    /**
     * The date format for outputting DateTime objects as string
     */
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public static function toDateString(\DateTime $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }
}
