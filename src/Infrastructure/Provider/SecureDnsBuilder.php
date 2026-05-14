<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Infrastructure\DTO\DnsSecDataInterface;

final class SecureDnsBuilder implements SecureDnsBuilderInterface
{
    /**
     * @param DnsSecDataInterface[] $dsRows
     */
    public function build(array $dsRows, bool $delegationSigned): SecureDNS
    {
        $dsData = [];
        foreach ($dsRows as $row) {
            $dsData[] = [
                'keyTag'     => $row->getKeyTag(),
                'algorithm'  => $row->getAlgorithm(),
                'digestType' => $row->getDigestType(),
                'digest'     => $row->getDigest(),
            ];
        }

        return new SecureDNS(
            $delegationSigned ?: null,
            $delegationSigned,
            null,
            $dsData ?: null,
        );
    }
}
