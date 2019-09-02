<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\Label;

use InvalidArgumentException;

abstract class ASCIILabel extends Label
{
    /**
     * ASCIILabel constructor.
     * @param string $label
     */
    public function __construct(string $label)
    {
        parent::__construct($label);

        if (!self::checkContains($label)) {
            throw new InvalidArgumentException('wrong character in label string');
        }
    }

    /**
     * @param string $string
     */
    public static function checkContains(string $string): bool
    {
        return mb_check_encoding($string, 'ASCII');
    }
}
