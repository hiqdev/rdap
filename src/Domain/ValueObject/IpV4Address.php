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

namespace hiqdev\rdap\core\Domain\ValueObject;

final class IpV4Address implements IpAddress
{
    /**
     * @var string
     */
    private $ip;

    public function __construct(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException(sprintf('Value %s is not a valid IPv4 address', $ip));
        }

        $this->ip = $ip;
    }

    /**
     * {@inheritdoc}
     */
    public function getHostAddress(): string
    {
        return $this->ip;
    }

    public function __toString(): string
    {
        return $this->getHostAddress();
    }
}
