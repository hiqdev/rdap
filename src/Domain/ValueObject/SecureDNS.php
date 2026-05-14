<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject;

use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\DSData;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\KeyData;

/**
 * DNSSEC information attached to a domain object, as defined by RFC 9083 §5.2.
 *
 * Groups zone-signed / delegation-signed flags, optional max signature lifetime,
 * DS records (DSData), and DNSKEY records (KeyData).
 */
class SecureDNS
{
    /**
     * @var bool|null
     */
    private $zoneSigned;

    /**
     * @var bool
     */
    private $delegationSigned;

    /**
     * @var int|null
     */
    private $maxSigLife;

    /**
     * @var DSData[]|null
     */
    private $dsData;

    /**
     * @var KeyData[]|null
     */
    private $keyData;

    /**
     * SecureDNS constructor.
     * @param bool $zoneSigned
     * @param bool $delegationSigned
     * @param int $maxSigLife
     * @param DSData[] $dsData
     * @param KeyData[] $keyData
     */
    public function __construct(
        ?bool $zoneSigned = null,
        bool $delegationSigned = false,
        ?int $maxSigLife = null,
        ?array $dsData = null,
        ?array $keyData = null
    ) {
        $this->zoneSigned = $zoneSigned;
        $this->delegationSigned = $delegationSigned;
        $this->maxSigLife = $maxSigLife;
        $this->dsData = $dsData;
        $this->keyData = $keyData;
    }

    /**
     * @return DSData[]
     */
    public function getDsData(): ?array
    {
        return $this->dsData ?? null;
    }

    /**
     * @return KeyData[]
     */
    public function getKeyData(): ?array
    {
        return $this->keyData ?? null;
    }

    /**
     * @return int
     */
    public function getMaxSigLife(): ?int
    {
        return $this->maxSigLife ?? null;
    }

    /**
     * @return bool
     */
    public function isDelegationSigned(): bool
    {
        return $this->delegationSigned;
    }

    /**
     * @return bool
     */
    public function isZoneSigned(): ?bool
    {
        return $this->zoneSigned ?? null;
    }
}
