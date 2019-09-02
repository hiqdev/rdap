<?php
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
 * Class Role.
 *
 * @method static self REGISTRANT()
 * @method static self TECHNICAL()
 * @method static self ADMINISTRATIVE()
 * @method static self ABUSE()
 * @method static self BILLING()
 * @method static self REGISTRAR()
 * @method static self RESELLER()
 * @method static self SPONSOR()
 * @method static self PROXY()
 * @method static self NOTIFICATIONS()
 * @method static self NOC()
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class Role extends Enum
{
    public const REGISTRANT     = 'registrant';
    public const TECHNICAL      = 'technical';
    public const ADMINISTRATIVE = 'administrative';
    public const ABUSE          = 'abuse';
    public const BILLING        = 'billing';
    public const REGISTRAR      = 'registrar';
    public const RESELLER       = 'reseller';
    public const SPONSOR        = 'sponsor';
    public const PROXY          = 'proxy';
    public const NOTIFICATIONS  = 'notifications';
    public const NOC            = 'noc';
}
