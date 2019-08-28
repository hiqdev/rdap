<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject\Label;

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
