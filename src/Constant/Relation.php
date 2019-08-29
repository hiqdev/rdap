<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Constant;

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
    public const BASIC                      = 'BASIC';
    public const REGISTERED                 = 'REGISTERED';
    public const UNREGISTERED               = 'UNREGISTERED';
    public const RESTRICTED_REGISTRATION    = 'RESTRICTED REGISTRATION';
    public const OPEN_REGISTRATION          = 'OPEN REGISTRATION';
    public const CONJOINED                  = 'CONJOINED';
}
