<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

/**
 * Interface IpAddress
 * @package hiqdev\rdap\core\ValueObject
 */
interface IpAddress
{
    /**
     * @return string
     */
    public function getHostAddress(): string;
}
