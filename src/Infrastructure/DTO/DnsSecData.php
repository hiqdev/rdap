<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

final class DnsSecData implements DnsSecDataInterface
{
    /** @var int */
    private $keyTag;

    /** @var int */
    private $algorithm;

    /** @var int */
    private $digestType;

    /** @var string */
    private $digest;

    public function __construct(int $keyTag, int $algorithm, int $digestType, string $digest)
    {
        $this->keyTag     = $keyTag;
        $this->algorithm  = $algorithm;
        $this->digestType = $digestType;
        $this->digest     = $digest;
    }

    public function getKeyTag(): int { return $this->keyTag; }
    public function getAlgorithm(): int { return $this->algorithm; }
    public function getDigestType(): int { return $this->digestType; }
    public function getDigest(): string { return $this->digest; }
}
