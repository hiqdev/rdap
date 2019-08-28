<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject\Label;

final class RootLabel extends Label
{
    /**
     * @var RootLabel
     */
    private static $instance;

    /**
     * @return RootLabel
     */
    public static function getInstance(): RootLabel
    {
        if (self::$instance === null) {
            self::$instance = new self('');
        }

        return self::$instance;
    }
}
