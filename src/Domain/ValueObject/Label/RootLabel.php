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
