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
 * Class EventAction.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @method static EventAction REGISTRATION()
 * @method static EventAction REREGISTRATION()
 * @method static EventAction LAST_CHANGED()
 * @method static EventAction EXPIRATION()
 * @method static EventAction DELETION()
 * @method static EventAction REINSTANTIATION()
 * @method static EventAction TRANSFER()
 * @method static EventAction LOCKED()
 * @method static EventAction UNLOCKED()
 * @method static EventAction LAST_UPDATE_OF_RDAP_DATABASE()
 */
final class EventAction extends Enum
{
    public const REGISTRATION                 = 'registration';
    public const REREGISTRATION               = 'reregistration';
    public const LAST_CHANGED                 = 'last changed';
    public const EXPIRATION                   = 'expiration';
    public const DELETION                     = 'deletion';
    public const REINSTANTIATION              = 'reinstantiation';
    public const TRANSFER                     = 'transfer';
    public const LOCKED                       = 'locked';
    public const UNLOCKED                     = 'unlocked';
    public const LAST_UPDATE_OF_RDAP_DATABASE = 'last update of RDAP database';
}
