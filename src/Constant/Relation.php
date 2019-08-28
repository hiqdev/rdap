<?php


namespace hiqdev\rdap\core\Constant;


use MabeEnum\Enum;

/**
 * Class Relation
 * @package hiqdev\rdap\core\Constant
 *
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
