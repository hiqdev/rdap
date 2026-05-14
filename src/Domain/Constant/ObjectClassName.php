<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Domain\Constant;

/** RDAP object class name values as defined in RFC 9083 §4.1. */
enum ObjectClassName: string
{
    case ENTITY     = 'entity';
    case NAMESERVER = 'nameserver';
    case DOMAIN     = 'domain';
    case AUTNUM     = 'autnum';
    case IPNETWORK  = 'ipnetwork';
}
