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
            return RootLabel::getInstanse();
        }
        if (!ASCIILabel::checkContains($name)) {

        }
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
        return $this;
    }

    public function toUnicode(): Label
    {
        return $this;
    }
}
