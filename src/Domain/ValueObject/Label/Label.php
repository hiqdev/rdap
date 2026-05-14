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

namespace hiqdev\rdap\core\Domain\ValueObject\Label;

/**
 * Abstract base for a single DNS label within a domain name.
 *
 * Subclasses: LDHLabel (ASCII letters/digits/hyphens), NonASCIILabel (IDN U-label),
 * and RootLabel (empty trailing label representing the DNS root).
 * The static factory Label::of() selects the appropriate subclass automatically.
 */
abstract class Label
{
    private const HYPHEN = '-';
    /**
     * @var string
     */
    protected $value;

    /** @param string $label Raw label value string */
    public function __construct(string $label)
    {
        $this->value = $label;
    }

    /**
     * @param  string $name Single domain label string (e.g. "com", "xn--nxasmq6b")
     * @return Label  RootLabel for empty string, NonASCIILabel for non-ASCII, LDHLabel otherwise
     */
    public static function of(string $name): Label
    {
        if ($name === '') {
            return RootLabel::getInstance();
        }

        if (!ASCIILabel::checkContains($name)) {
            return new NonASCIILabel($name);
        }

        return new LDHLabel($name);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /** @return string Raw label value string */
    public function __toString(): string
    {
        return $this->value;
    }

    /** @return Label A new LDHLabel with the ACE (punycode) form of this label */
    public function toLDH(): Label
    {
        return new LDHLabel(idn_to_ascii($this->value, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46));
    }

    /** @return Label A new NonASCIILabel with the Unicode (U-label) form of this label */
    public function toUnicode(): Label
    {
        return new NonASCIILabel(idn_to_utf8($this->value, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46));
    }
}
