<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Domain\Constant;

/** RDAP object status values as defined in RFC 9083 §10.2.2 and the ICANN EPP status mapping. */
enum Status: string
{
    case OK                       = 'active';
    case VALIDATED                = 'validated';
    case RENEWPROHIBITED          = 'renew prohibited';
    case UPDATEPROHIBITED         = 'update prohibited';
    case TRANSFERPROHIBITED       = 'transfer prohibited';
    case DELETEPROHIBITED         = 'delete prohibited';
    case PROXY                    = 'proxy';
    case PRIVATE                  = 'private';
    case REMOVED                  = 'removed';
    case OBSCURED                 = 'obscured';
    case ASSOCIATED               = 'associated';
    case INACTIVE                 = 'inactive';
    case LOCKED                   = 'locked';
    case PENDINGCREATE            = 'pending create';
    case PENDINGRENEW             = 'pending renew';
    case PENDINGTRANSFER          = 'pending transfer';
    case PENDINGUPDATE            = 'pending update';
    case PENDINGDELETE            = 'pending delete';
    case ADDPERIOD                = 'add period';
    case AUTORENEWPERIOD          = 'auto renew period';
    case PENDINGRESTORE           = 'pending restore';
    case REDEMPTIONPERIOD         = 'redemption period';
    case RENEWPERIOD              = 'renew period';
    case SERVERDELETEPROHIBITED   = 'server delete prohibited';
    case SERVERHOLD               = 'server hold';
    case SERVERRENEWPROHIBITED    = 'server renew prohibited';
    case SERVERTRANSFERPROHIBITED = 'server transfer prohibited';
    case SERVERUPDATEPROHIBITED   = 'server update prohibited';
    case TRANSFERPERIOD           = 'transfer period';
    case CLIENTDELETEPROHIBITED   = 'client delete prohibited';
    case CLIENTHOLD               = 'client hold';
    case CLIENTRENEWPROHIBITED    = 'client renew prohibited';
    case CLIENTTRANSFERPROHIBITED = 'client transfer prohibited';
    case CLIENTUPDATEPROHIBITED   = 'client update prohibited';

    /**
     * @param  string $name Enum case name in UPPER_SNAKE_CASE (e.g. "OK")
     * @return self
     */
    public static function fromName(string $name): self
    {
        return constant('self::' . $name);
    }
}
