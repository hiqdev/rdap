<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Domain\Constant;

/** RDAP entity role values as defined in RFC 9083 §10.2.4. */
enum Role: string
{
    case REGISTRANT     = 'registrant';
    case TECHNICAL      = 'technical';
    case ADMINISTRATIVE = 'administrative';
    case ABUSE          = 'abuse';
    case BILLING        = 'billing';
    case REGISTRAR      = 'registrar';
    case RESELLER       = 'reseller';
    case SPONSOR        = 'sponsor';
    case PROXY          = 'proxy';
    case NOTIFICATIONS  = 'notifications';
    case NOC            = 'noc';

    /**
     * @param  string $name Enum case name in UPPER_SNAKE_CASE (e.g. "REGISTRANT")
     * @return self
     */
    public static function fromName(string $name): self
    {
        return constant('self::' . $name);
    }
}
