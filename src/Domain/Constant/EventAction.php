<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Domain\Constant;

/** RDAP event action values as defined in RFC 9083 §10.2.3. */
enum EventAction: string
{
    case REGISTRATION                 = 'registration';
    case REREGISTRATION               = 'reregistration';
    case LAST_CHANGED                 = 'last changed';
    case EXPIRATION                   = 'expiration';
    case REGISTRAR_EXPIRATION         = 'registrar expiration';
    case DELETION                     = 'deletion';
    case REINSTANTIATION              = 'reinstantiation';
    case TRANSFER                     = 'transfer';
    case LOCKED                       = 'locked';
    case UNLOCKED                     = 'unlocked';
    case LAST_UPDATE_OF_RDAP_DATABASE = 'last update of RDAP database';
}
