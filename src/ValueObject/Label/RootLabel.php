<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject\Label;

final class RootLabel extends Label
{
    /**
     * @var RootLabel
     */
    private static $instance;

    private function __construct(string $label)
    {
        parent::__construct($label);
    }

    /**
     * @return RootLabel
     */
    public static function getInstance(): RootLabel
    {
        if (!isset(self::$instance)) {
            self::$instance = new self('');
        }

        return self::$instance;
    }
}
