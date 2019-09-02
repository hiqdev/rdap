<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace JeroenDesloovere\VCard {
    function date($format)
    {
        return \date($format, VCardDateMock::getDate()->getTimestamp());
    }

    final class VCardDateMock
    {
        /**
         * @var \DateTimeImmutable|null
         */
        private static $date;

        public static function setDate(\DateTimeImmutable $dateTime): void
        {
            self::$date = $dateTime;
        }

        public static function getDate(): \DateTimeImmutable
        {
            return self::$date ?? new \DateTimeImmutable();
        }
    }
}
