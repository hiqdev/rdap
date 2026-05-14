<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

use DateTimeImmutable;

/** Read contract for a domain registration data DTO (handles, dates, statuses, nameservers, WHOIS/DNSSEC flags). */
interface DomainDataInterface
{
    /** @return string Registry-unique domain handle (ROID) */
    public function getHandle(): string;

    /** @return string|null Comma-separated EPP status values, or null if none */
    public function getStatuses(): ?string;

    /** @return string|null Comma-separated nameserver hostnames, or null if none */
    public function getNameservers(): ?string;

    /** @return DateTimeImmutable Domain registration date (UTC) */
    public function getCreationDate(): DateTimeImmutable;

    /** @return DateTimeImmutable Date of last registry update (UTC) */
    public function getUpdatedDate(): DateTimeImmutable;

    /** @return DateTimeImmutable Registrar-level expiry date (UTC) */
    public function getRegistrarExpiration(): DateTimeImmutable;

    /** @return DateTimeImmutable Registry-level expiry date (UTC) */
    public function getExpiration(): DateTimeImmutable;

    /** @return bool True when the domain is under WHOIS privacy protection */
    public function isWhoisProtected(): bool;

    /** @return bool True when DNSSEC delegation signatures are present */
    public function isDelegationSigned(): bool;
}
