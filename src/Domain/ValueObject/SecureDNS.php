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

class SecureDNS
{
    /**
     * @var bool
     */
    private $zoneSigned;

    /**
     * @var bool
     */
    private $delegationSigned;

    /**
     * @var int
     */
    private $maxSigLife;

    /**
     * @var DSData[]
     */
    private $dsData;

    /**
     * @var KeyData[]
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
        bool $zoneSigned,
        bool $delegationSigned,
        int $maxSigLife,
        array $dsData,
        array $keyData
    ) {
        $this->delegationSigned = $delegationSigned;
        $this->zoneSigned = $zoneSigned;
        $this->maxSigLife = $maxSigLife;
        $this->dsData = $dsData;
        $this->keyData = $keyData;
    }

    /**
     * @return DSData[]
     */
    public function getDsData(): array
    {
        return $this->dsData;
    }

    /**
     * @return KeyData[]
     */
    public function getKeyData(): array
    {
        return $this->keyData;
    }

    /**
     * @return int
     */
    public function getMaxSigLife(): int
    {
        return $this->maxSigLife;
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
    public function isZoneSigned(): bool
    {
        return $this->zoneSigned;
    }
}
