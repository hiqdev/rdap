<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

use DateTimeImmutable;

interface DomainDataInterface
{
    public function getHandle(): string;
    public function getStatuses(): ?string;
    public function getNameservers(): ?string;
    public function getCreationDate(): DateTimeImmutable;
    public function getUpdatedDate(): DateTimeImmutable;
    public function getRegistrarExpiration(): DateTimeImmutable;
    public function getExpiration(): DateTimeImmutable;
    public function isWhoisProtected(): bool;
    public function isDelegationSigned(): bool;
}
