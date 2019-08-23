<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

use hiqdev\rdap\core\ValueObject\Label\Label;
use hiqdev\rdap\core\ValueObject\Label\RootLabel;
use http\Exception\InvalidArgumentException;

final class DomainName
{
    /**
     * @var Label[]
     */
    private $labels = [];

    /**
     * DomainName constructor.
     * @param array $labels
     * @throws \ArgumentCountError
     * @throws \InvalidArgumentException
     */
    private function __construct(array $labels)
    {
        if (count($labels) === 0) {
            throw new \ArgumentCountError('labels size should be > 0');
        }
        $lastEl = array_pop($labels);
        array_map(function ($el) {
            if ($el instanceof RootLabel) {
                throw new InvalidArgumentException("Only the last label may be a root label");
            }
        }, $labels);
        $labels[] = $lastEl;
        $this->labels = $labels;
    }

    public static function of(string $domainName): self
    {
        $labels = explode('.', $domainName);

        foreach ($labels as $label) {
            $builder[] = Label::of($label);
        }
        return new DomainName($builder);
    }

    public function toFQDN(): self
    {
        if ($this->isFQDN()) {
            return $this;
        }
        return new DomainName(RootLabel::getInstanse());
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
        foreach ($this->labels as $label) {
            $str[] = (string)$label;
        }
        return implode('.', $str);
    }

    public function toLDH(): self
    {
        /** @var DomainName $label */
        foreach ($this->labels as $label) {
            $ldh[] = $label->toLDH();
        }
        return new DomainName($ldh);
    }

    public function toUnicode(): self
    {
        foreach ($this->labels as $label) {
            $uni[] = $label->toUnicode();
        }
        return new DomainName($uni);
    }

    /**
     * @param DomainName $other
     * @return bool
     */
    public function equals(DomainName $other): bool
    {
        if (!($other instanceof DomainName))
            return false;
        if ($other == $this)
            return true;
        return $this->toLDH() == $other->toLDH();
    }

    public function hashCode(): string
    {
        return spl_object_hash($this->toLDH());
    }
}
