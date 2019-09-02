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

abstract class Label
{
    private const HYPHEN = '-';
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $label)
    {
        $this->value = $label;
    }

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

    public function __toString(): string
    {
        return $this->value;
    }

    public function toLDH(): Label
    {
        return new LDHLabel(idn_to_ascii($this->value, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46));
    }

    public function toUnicode(): Label
    {
        return new NonASCIILabel(idn_to_utf8($this->value, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46));
    }
}
