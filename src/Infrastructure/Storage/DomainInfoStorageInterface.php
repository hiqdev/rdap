<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Storage;

interface DomainInfoStorageInterface
{
    /** @param string $domainName Fully-qualified domain name used as the storage key */
    public function save(string $domainName, string $json): void;

    /**
     * @param  string $domainName Fully-qualified domain name
     * @return string|null Stored RDAP JSON, or null if not found
     */
    public function find(string $domainName): ?string;

    /** @param string $domainName Fully-qualified domain name whose record should be removed */
    public function delete(string $domainName): void;

    /** @param \DateTimeImmutable $threshold Remove all records that were not updated after this point in time */
    public function removeNotUpdatedSince(\DateTimeImmutable $threshold): void;
}
