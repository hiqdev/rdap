<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

/** Immutable DTO carrying a single DS record (key tag, algorithm, digest type, and digest hex). */
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

    /**
     * @param int    $keyTag     Key tag of the referenced DNSKEY
     * @param int    $algorithm  DNSSEC algorithm number
     * @param int    $digestType Digest type identifier (e.g. 2 = SHA-256)
     * @param string $digest     Hex-encoded digest value
     */
    public function __construct(int $keyTag, int $algorithm, int $digestType, string $digest)
    {
        $this->keyTag     = $keyTag;
        $this->algorithm  = $algorithm;
        $this->digestType = $digestType;
        $this->digest     = $digest;
    }

    /** @return int Key tag identifying the referenced DNSKEY record */
    public function getKeyTag(): int { return $this->keyTag; }
    /** @return int DNSSEC algorithm number */
    public function getAlgorithm(): int { return $this->algorithm; }
    /** @return int Digest type (1 = SHA-1, 2 = SHA-256, 4 = SHA-384) */
    public function getDigestType(): int { return $this->digestType; }
    /** @return string Hex-encoded digest of the DNSKEY record */
    public function getDigest(): string { return $this->digest; }
}
