<?php


namespace hiqdev\rdap\core\Constant;


use MabeEnum\Enum;

/**
 * Class Role
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
    public const REGISTRANT     = 'REGISTRANT';
    public const TECHNICAL      = 'TECHNICAL';
    public const ADMINISTRATIVE = 'ADMINISTRATIVE';
    public const ABUSE          = 'ABUSE';
    public const BILLING        = 'BILLING';
    public const REGISTRAR      = 'REGISTRAR';
    public const RESELLER       = 'RESELLER';
    public const SPONSOR        = 'SPONSOR';
    public const PROXY          = 'PROXY';
    public const NOTIFICATIONS  = 'NOTIFICATIONS';
    public const NOC            = 'NOC';
}
