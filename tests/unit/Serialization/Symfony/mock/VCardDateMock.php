<?php

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
