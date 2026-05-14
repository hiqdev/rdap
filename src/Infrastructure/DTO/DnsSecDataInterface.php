<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

interface DnsSecDataInterface
{
    public function getKeyTag(): int;
    public function getAlgorithm(): int;
    public function getDigestType(): int;
    public function getDigest(): string;
}
