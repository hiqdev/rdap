<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

/** Read contract for a single DNSSEC DS record DTO. */
interface DnsSecDataInterface
{
    /** @return int DS record key tag (identifies the referenced DNSKEY) */
    public function getKeyTag(): int;

    /** @return int DNSSEC algorithm number (see IANA DNS Security Algorithm Numbers) */
    public function getAlgorithm(): int;

    /** @return int Digest type identifier (1 = SHA-1, 2 = SHA-256, 4 = SHA-384) */
    public function getDigestType(): int;

    /** @return string Hex-encoded digest of the DNSKEY record */
    public function getDigest(): string;
}
