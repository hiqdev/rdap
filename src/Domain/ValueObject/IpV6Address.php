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

use function filter_var;

/**
 * Class IpV6Address.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class IpV6Address implements IpAddress
{
    /**
     * @var string
     */
    private $ip;

    /**
     * @param string $ip Colon-separated IPv6 address string (e.g. "2001:db8::1")
     * @throws \InvalidArgumentException if the value is not a valid IPv6 address
     */
    public function __construct(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            throw new \InvalidArgumentException(sprintf('Value %s is not a valid IPv6 address', $ip));
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

    /** @return string Colon-separated IPv6 address string */
    public function __toString(): string
    {
        return $this->getHostAddress();
    }
}
