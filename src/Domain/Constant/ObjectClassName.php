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
 * Class ObjectClassName.
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
