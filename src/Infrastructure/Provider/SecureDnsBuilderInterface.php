<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Infrastructure\DTO\DnsSecDataInterface;

/** Builds a SecureDNS value object from a list of DS record DTOs. */
interface SecureDnsBuilderInterface
{
    /**
     * @param DnsSecDataInterface[] $dsRows
     */
    public function build(array $dsRows, bool $delegationSigned): SecureDNS;
}
