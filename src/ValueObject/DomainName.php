<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

use hiqdev\rdap\core\ValueObject\Label\Label;

final class DomainName
{
    /**
     * @var Label[]
     */
    private $labels = [];

    private function __construct()
    {
    }

    public static function of(string $domainName): self
    {
    }

    public static function toFQDN(): self
    {
    }

    public function isFQDN(): bool
    {
    }

    public function getLevelSize(): int
    {
    }

    public function getTLDLabel(): Label
    {
    }

    public function __toString(): string
    {
    }

    public function toLDH(): self
    {
    }

    public function toUnicode(): self
    {
    }

    public function equals(DomainName $other): bool
    {
    }
}
