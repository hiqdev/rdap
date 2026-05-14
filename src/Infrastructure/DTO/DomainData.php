<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

use DateTimeImmutable;
use DateTimeZone;

/**
 * Immutable DTO carrying raw domain registration data fetched from the registry DB.
 *
 * Date strings passed to the constructor are parsed into DateTimeImmutable objects
 * normalised to UTC. Implements DomainDataInterface for use across the provider layer.
 */
final class DomainData implements DomainDataInterface
{
    private string $handle;
    private ?string $statuses;
    private ?string $nameservers;
    private DateTimeImmutable $creationDate;
    private DateTimeImmutable $updatedDate;
    private DateTimeImmutable $registrarExpiration;
    private DateTimeImmutable $expiration;
    private bool $whoisProtected;
    private bool $delegationSigned;

    /**
     * @param string  $handle              Registry-unique domain handle (ROID)
     * @param string|null $statuses        Comma-separated EPP statuses, or null
     * @param string|null $nameservers     Comma-separated nameserver hostnames, or null
     * @param string  $creationDate        Registration date string parseable by DateTimeImmutable
     * @param string  $updatedDate         Last-update date string
     * @param string  $registrarExpiration Registrar-level expiry date string
     * @param string  $expiration          Registry-level expiry date string
     * @param bool    $whoisProtected      Whether WHOIS privacy is active
     * @param bool    $delegationSigned    Whether DNSSEC delegation signatures are present
     */
    public function __construct(
        string $handle,
        ?string $statuses,
        ?string $nameservers,
        string $creationDate,
        string $updatedDate,
        string $registrarExpiration,
        string $expiration,
        bool $whoisProtected,
        bool $delegationSigned
    ) {
        $utc = new DateTimeZone('UTC');
        $this->handle              = $handle;
        $this->statuses            = $statuses;
        $this->nameservers         = $nameservers;
        $this->creationDate        = new DateTimeImmutable($creationDate, $utc);
        $this->updatedDate         = new DateTimeImmutable($updatedDate, $utc);
        $this->registrarExpiration = new DateTimeImmutable($registrarExpiration, $utc);
        $this->expiration          = new DateTimeImmutable($expiration, $utc);
        $this->whoisProtected      = $whoisProtected;
        $this->delegationSigned    = $delegationSigned;
    }

    /** @return string Registry-unique domain handle (ROID) */
    public function getHandle(): string { return $this->handle; }
    /** @return string|null Comma-separated EPP status values, or null */
    public function getStatuses(): ?string { return $this->statuses; }
    /** @return string|null Comma-separated nameserver hostnames, or null */
    public function getNameservers(): ?string { return $this->nameservers; }
    /** @return DateTimeImmutable Domain registration date (UTC) */
    public function getCreationDate(): DateTimeImmutable { return $this->creationDate; }
    /** @return DateTimeImmutable Date of last registry update (UTC) */
    public function getUpdatedDate(): DateTimeImmutable { return $this->updatedDate; }
    /** @return DateTimeImmutable Registrar-level expiry date (UTC) */
    public function getRegistrarExpiration(): DateTimeImmutable { return $this->registrarExpiration; }
    /** @return DateTimeImmutable Registry-level expiry date (UTC) */
    public function getExpiration(): DateTimeImmutable { return $this->expiration; }
    /** @return bool True when WHOIS privacy protection is active */
    public function isWhoisProtected(): bool { return $this->whoisProtected; }
    /** @return bool True when DNSSEC delegation signatures are present */
    public function isDelegationSigned(): bool { return $this->delegationSigned; }
}
