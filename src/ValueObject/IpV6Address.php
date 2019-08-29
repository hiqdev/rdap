<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

use function filter_var;

/**
 * Class IpV6Address
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class IpV6Address implements IpAddress
{
    /**
     * @var string
     */
    private $ip;

    public function __construct(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            throw new \InvalidArgumentException(sprintf('Value %s is not a valid IPv6 address', $ip));
        }

        $this->ip = $ip;
    }

    /**
     * @inheritDoc
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
