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

/**
 * Immutable value object representing a DNS domain name as an ordered list of labels.
 *
 * Supports conversion between LDH (ACE/punycode) and Unicode (U-label) forms,
 * FQDN normalisation, and label-level access. Constructed via the static factory
 * DomainName::of() which parses a dot-separated string into Label instances.
 */
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

    /**
     * @param  string $domainName Dot-separated domain name string (e.g. "example.com")
     * @return self
     */
    public static function of(string $domainName): self
    {
        $builder = [];
        foreach (explode('.', $domainName) as $label) {
            $builder[] = Label::of(mb_strtolower($label));
        }

        return new DomainName($builder);
    }

    /** @return self A fully-qualified version of this domain name (trailing dot label appended if absent) */
    public function toFQDN(): self
    {
        if ($this->isFQDN()) {
            return $this;
        }
        $labels = $this->labels;
        $labels[] = RootLabel::getInstance();

        return new DomainName($labels);
    }

    /** @return bool True when the last label is the root label (empty trailing dot) */
    public function isFQDN(): bool
    {
        return $this->labels[count($this->labels) - 1] instanceof RootLabel;
    }

    /** @return int Number of meaningful labels (root label excluded) */
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

    /** @return Label The top-level domain label (rightmost non-root label) */
    public function getTLDLabel(): Label
    {
        return $this->labels[$this->getLevelSize() - 1];
    }

    /** @return string Dot-joined label string (e.g. "example.com") */
    public function __toString(): string
    {
        return implode('.', $this->labels);
    }

    /** @return self A copy of this domain name with all labels converted to LDH (ASCII-compatible encoding) */
    public function toLDH(): self
    {
        $ldh = array_map(static function (Label $label): Label {
            return $label->toLDH();
        }, $this->labels);

        return new DomainName($ldh);
    }

    /** @return self A copy of this domain name with all labels decoded to Unicode (U-label form) */
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

    /** @return string Object hash of the LDH-normalised domain name */
    public function hashCode(): string
    {
        return spl_object_hash($this->toLDH());
    }
}
