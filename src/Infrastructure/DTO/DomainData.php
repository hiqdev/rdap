<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

use DateTimeImmutable;
use DateTimeZone;

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

    public function getHandle(): string { return $this->handle; }
    public function getStatuses(): ?string { return $this->statuses; }
    public function getNameservers(): ?string { return $this->nameservers; }
    public function getCreationDate(): DateTimeImmutable { return $this->creationDate; }
    public function getUpdatedDate(): DateTimeImmutable { return $this->updatedDate; }
    public function getRegistrarExpiration(): DateTimeImmutable { return $this->registrarExpiration; }
    public function getExpiration(): DateTimeImmutable { return $this->expiration; }
    public function isWhoisProtected(): bool { return $this->whoisProtected; }
    public function isDelegationSigned(): bool { return $this->delegationSigned; }
}
