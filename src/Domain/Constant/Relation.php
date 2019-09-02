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
 * Class Relation.
 *
 * @method static self BASIC()
 * @method static self REGISTERED()
 * @method static self REGISTRATION()
 * @method static self UNREGISTERED()
 * @method static self RESTRICTED_REGISTRATION()
 * @method static self OPEN_REGISTRATION()
 * @method static self CONJOINED()
 */
class Relation extends Enum
{
    public const BASIC                      = 'basic';
    public const REGISTERED                 = 'registered';
    public const UNREGISTERED               = 'unregistered';
    public const RESTRICTED_REGISTRATION    = 'restricted registration';
    public const OPEN_REGISTRATION          = 'open registration';
    public const CONJOINED                  = 'conjoined';
}
