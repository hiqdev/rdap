<?php

namespace hiqdev\rdap\core\Constant;

use MabeEnum\Enum;

/**
 * Class ObjectClassName
 *
 * @method static self ENTITY()
 * @method static self NAMESERVER()
 * @method static self DOMAIN()
 * @method static self AUTNUM()
 * @method static self IPNETWORK()
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class ObjectClassName extends Enum
{
    public const ENTITY     = 'entity';
    public const NAMESERVER = 'nameserver';
    public const DOMAIN     = 'domain';
    public const AUTNUM     = 'autnum';
    public const IPNETWORK  = 'ipnetwork';
}
