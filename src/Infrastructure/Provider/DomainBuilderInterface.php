<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\DTO\ContactDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DnsSecDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DomainDataInterface;

interface DomainBuilderInterface
{
    /**
     * @param ContactDataInterface[] $contacts
     * @param DnsSecDataInterface[]|null $secureDnsData
     */
    public function build(
        DomainName $domainName,
        DomainDataInterface $domainData,
        array $contacts,
        ?array $secureDnsData
    ): Domain;
}
