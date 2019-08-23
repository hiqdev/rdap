<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject\Label;

use InvalidArgumentException;

abstract class ASCIILabel extends Label
{
    public function __construct(string $label)
    {
        parent::__construct($label);

        if (!self::checkContains($label)) {
            throw new InvalidArgumentException('wrong character in label string');
        }
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function checkContains(string $string): bool
    {
        return mb_check_encoding($string, 'ASCII');
    }
}
