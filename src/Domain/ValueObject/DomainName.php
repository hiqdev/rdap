<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject;

use ArgumentCountError;
use hiqdev\rdap\core\Domain\ValueObject\Label\Label;
use hiqdev\rdap\core\Domain\ValueObject\Label\RootLabel;
use InvalidArgumentException;

final class DomainName
{
    /**
     * @var Label[]
     */
    private $labels;

    /**
     * DomainName constructor.
     * @param Label[] $labels
     * @throws ArgumentCountError
     * @throws InvalidArgumentException
     */
    private function __construct(array $labels)
    {
        if (count($labels) === 0) {
            throw new ArgumentCountError('Labels size MUST be > 0');
        }
        $lastEl = array_pop($labels);
        foreach ($labels as $label) {
            if ($label instanceof RootLabel) {
                throw new InvalidArgumentException('Only the last label may be a root label');
            }
        }
        $labels[] = $lastEl;
        $this->labels = $labels;
    }

    public static function of(string $domainName): self
    {
        $builder = [];
        foreach (explode('.', $domainName) as $label) {
            $builder[] = Label::of(mb_strtolower($label));
        }

        return new DomainName($builder);
    }

    public function toFQDN(): self
    {
        if ($this->isFQDN()) {
            return $this;
        }
        $labels = $this->labels;
        $labels[] = RootLabel::getInstance();

        return new DomainName($labels);
    }

    public function isFQDN(): bool
    {
        return $this->labels[count($this->labels) - 1] instanceof RootLabel;
    }

    public function getLevelSize(): int
    {
        return $this->isFQDN() ? count($this->labels) - 1 : count($this->labels);
    }

    /**
     * @return Label[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getTLDLabel(): Label
    {
        return $this->labels[$this->getLevelSize() - 1];
    }

    public function __toString(): string
    {
        return implode('.', $this->labels);
    }

    public function toLDH(): self
    {
        $ldh = array_map(static function (Label $label): Label {
            return $label->toLDH();
        }, $this->labels);

        return new DomainName($ldh);
    }

    public function toUnicode(): self
    {
        $uni = array_map(static function (Label $label): Label {
            return $label->toUnicode();
        }, $this->labels);

        return new DomainName($uni);
    }

    /**
     * @param DomainName $other
     * @return bool
     */
    public function equals(DomainName $other): bool
    {
        if ($other === $this) {
            return true;
        }

        return (string) $this->toLDH() === (string) $other->toLDH();
    }

    public function hashCode(): string
    {
        return spl_object_hash($this->toLDH());
    }
}
