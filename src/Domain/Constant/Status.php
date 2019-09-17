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

namespace hiqdev\rdap\core\Domain\Constant;

use MabeEnum\Enum;

/**
 * Class Status.
 *
 * @method static self OK()
 * @method static self VALIDATED()
 * @method static self RENEWPROHIBITED()
 * @method static self UPDATEPROHIBITED()
 * @method static self TRANSFERPROHIBITED()
 * @method static self DELETEPROHIBITED()
 * @method static self PROXY()
 * @method static self PRIVATE()
 * @method static self REMOVED()
 * @method static self OBSCURED()
 * @method static self ASSOCIATED()
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 * @method static self LOCKED()
 * @method static self PENDINGCREATE()
 * @method static self PENDINGRENEW()
 * @method static self PENDINGTRANSFER()
 * @method static self PENDINGUPDATE()
 * @method static self PENDINGDELETE()
 * @method static self ADDPERIOD()
 * @method static self AUTORENEWPERIOD()
 * @method static self PENDINGRESTORE()
 * @method static self REDEMPTIONPERIOD()
 * @method static self RENEWPERIOD()
 * @method static self SERVERDELETEPROHIBITED()
 * @method static self SERVERHOLD()
 * @method static self SERVERRENEWPROHIBITED()
 * @method static self SERVERTRANSFERPROHIBITED()
 * @method static self SERVERUPDATEPROHIBITED()
 * @method static self TRANSFERPERIOD()
 * @method static self CLIENTDELETEPROHIBITED()
 * @method static self CLIENTHOLD()
 * @method static self CLIENTRENEWPROHIBITED()
 * @method static self CLIENTTRANSFERPROHIBITED()
 * @method static self CLIENTUPDATEPROHIBITED()
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class Status extends Enum
{
    public const OK                       = 'active';
    public const VALIDATED                = 'validated';
    public const RENEWPROHIBITED          = 'renew prohibited';
    public const UPDATEPROHIBITED         = 'update prohibited';
    public const TRANSFERPROHIBITED       = 'transfer prohibited';
    public const DELETEPROHIBITED         = 'delete prohibited';
    public const PROXY                    = 'proxy';
    public const PRIVATE                  = 'private';
    public const REMOVED                  = 'removed';
    public const OBSCURED                 = 'obscured';
    public const ASSOCIATED               = 'associated';
    public const INACTIVE                 = 'inactive';
    public const LOCKED                   = 'locked';
    public const PENDINGCREATE            = 'pending create';
    public const PENDINGRENEW             = 'pending renew';
    public const PENDINGTRANSFER          = 'pending transfer';
    public const PENDINGUPDATE            = 'pending update';
    public const PENDINGDELETE            = 'pending delete';
    public const ADDPERIOD                = 'add period';
    public const AUTORENEWPERIOD          = 'auto renew period';
    public const PENDINGRESTORE           = 'pending restore';
    public const REDEMPTIONPERIOD         = 'redemption period';
    public const RENEWPERIOD              = 'renew period';
    public const SERVERDELETEPROHIBITED   = 'server delete prohibited';
    public const SERVERHOLD               = 'server hold';
    public const SERVERRENEWPROHIBITED    = 'server renew prohibited';
    public const SERVERTRANSFERPROHIBITED = 'server transfer prohibited';
    public const SERVERUPDATEPROHIBITED   = 'server update prohibited';
    public const TRANSFERPERIOD           = 'transfer period';
    public const CLIENTDELETEPROHIBITED   = 'client delete prohibited';
    public const CLIENTHOLD               = 'client hold';
    public const CLIENTRENEWPROHIBITED    = 'client renew prohibited';
    public const CLIENTTRANSFERPROHIBITED = 'client transfer prohibited';
    public const CLIENTUPDATEPROHIBITED   = 'client update prohibited';
}
