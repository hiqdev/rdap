<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Constant;

use MabeEnum\Enum;

/**
 * Class Status
 *
 * @method static self VALIDATED()
 * @method static self RENEW_PROHIBITED()
 * @method static self UPDATE_PROHIBITED()
 * @method static self TRANSFER_PROHIBITED()
 * @method static self DELETE_PROHIBITED()
 * @method static self PROXY()
 * @method static self PRIVATE()
 * @method static self REMOVED()
 * @method static self OBSCURED()
 * @method static self ASSOCIATED()
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 * @method static self LOCKED()
 * @method static self PENDING_CREATE()
 * @method static self PENDING_RENEW()
 * @method static self PENDING_TRANSFER()
 * @method static self PENDING_UPDATE()
 * @method static self PENDING_DELETE()
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class Status extends Enum
{
    public const VALIDATED           = 'validated';
    public const RENEW_PROHIBITED    = 'renew prohibited';
    public const UPDATE_PROHIBITED   = 'update prohibited';
    public const TRANSFER_PROHIBITED = 'transfer prohibited';
    public const DELETE_PROHIBITED   = 'delete prohibited';
    public const PROXY               = 'proxy';
    public const PRIVATE             = 'private';
    public const REMOVED             = 'removed';
    public const OBSCURED            = 'obscured';
    public const ASSOCIATED          = 'associated';
    public const ACTIVE              = 'active';
    public const INACTIVE            = 'inactive';
    public const LOCKED              = 'locked';
    public const PENDING_CREATE      = 'pending create';
    public const PENDING_RENEW       = 'pending renew';
    public const PENDING_TRANSFER    = 'pending transfer';
    public const PENDING_UPDATE      = 'pending update';
    public const PENDING_DELETE      = 'pending delete';
}
