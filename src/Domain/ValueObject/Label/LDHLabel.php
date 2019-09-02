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
 * Class LDHLabel
 * LDH (Letter, Digit, Hyphen)
 * The hostname convention defined in RFC 952 (later modified by RFC 1123) was used by top-level
 * domain Registries before internationalization. This meant that domain names could only practically
 * contain the letters a-z, digits 0-9 and the hyphen "-". The term "LDH code points" refers to this subset.
 * With the introduction of IDNs this rule is no longer relevant for all domain names although with the use of IDNA,
 * what appears in the DNS remains LDH.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class LDHLabel extends ASCIILabel
{
    public function __construct(string $label)
    {
        parent::__construct($label);

        $this->ensureIsLDH();
    }

    /**
     * @throws \OutOfRangeException if value is not LDH
     */
    private function ensureIsLDH(): void
    {
        if (!preg_match('/^[A-Z0-9-]+$/i', $this->value)) {
            throw new \OutOfRangeException(sprintf(
                'Value "%s" is not a valid LDH label',
                $this->value
            ));
        }
    }
}
