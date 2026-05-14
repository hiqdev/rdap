<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;

/**
 * Orchestrates fetching and assembling a complete RDAP Domain entity.
 *
 * Retrieves domain data, contacts, and DS records from the repository,
 * then delegates to DomainBuilderInterface to produce the final Domain object.
 */
final class DomainProvider implements DomainProviderInterface
{
    /** @var DomainRepositoryInterface */
    private $repository;

    /** @var DomainBuilderInterface */
    private $builder;

    /**
     * @param DomainRepositoryInterface $repository Data source for domain, contact, and DS records
     * @param DomainBuilderInterface    $builder    Assembles the RDAP Domain entity from raw data
     */
    public function __construct(DomainRepositoryInterface $repository, DomainBuilderInterface $builder)
    {
        $this->repository = $repository;
        $this->builder    = $builder;
    }

    /**
     * @param  DomainName $domainName Domain to look up
     * @return Domain     Fully populated RDAP domain entity
     * @throws \hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException if not found
     */
    public function get(DomainName $domainName): Domain
    {
        $name       = (string)$domainName;
        $domainData = $this->repository->findDomainByName($name);
        $contacts   = $this->repository->findContactsByDomainName($name);

        $secureDnsData = $domainData->isDelegationSigned()
            ? $this->repository->findSecDnsByDomainName($name)
            : null;

        return $this->builder->build($domainName, $domainData, $contacts, $secureDnsData);
    }
}
