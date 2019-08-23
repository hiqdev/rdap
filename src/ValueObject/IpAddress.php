<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

interface IpAddress
{
    public function getHostAddress(): string;
}
