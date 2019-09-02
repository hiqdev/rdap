<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\Entity;

use hiqdev\rdap\core\Domain\Constant\ObjectClassName;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;

/**
 * Class Nameserver.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Nameserver extends Common
{
    /**
     * @var string|null
     */
    private $handle;

    /**
     * @var DomainName
     */
    private $ldhName;

    /**
     * @var IpAddresses|null
     */
    private $ipAddresses;

    public function __construct(
        DomainName $ldhName,
        IpAddresses $ipAddresses = null
    ) {
        parent::__construct(ObjectClassName::NAMESERVER());

        $this->ldhName = $ldhName->toLDH();
        $this->ipAddresses = $ipAddresses;
    }

    public function getHandle(): ?string
    {
        return $this->handle;
    }

    public function setHandle(?string $handle): void
    {
        $this->handle = $handle;
    }

    public function getLdhName(): DomainName
    {
        return $this->ldhName;
    }

    public function getIpAddresses(): ?IpAddresses
    {
        return $this->ipAddresses;
    }
}
