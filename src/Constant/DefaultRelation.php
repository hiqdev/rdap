<?php


namespace hiqdev\rdap\core\Constant\Relations;


use MabeEnum\Enum;

/**
 * Class DefaultRelation
 * @package hiqdev\rdap\core\Constant\Relations
 *
 * @method static self REGISTRATION()
 * @method static self UNREGISTERED()
 * @method static self RESTRICTED_REGISTRATION()
 * @method static self OPEN_REGISTRATION()
 * @method static self CONJOINED()
 */
class DefaultRelation extends Enum
{
    public const REGISTERED                 = 'REGISTERED';
    public const UNREGISTERED               = 'UNREGISTERED';
    public const RESTRICTED_REGISTRATION    = 'RESTRICTED REGISTRATION';
    public const OPEN_REGISTRATION          = 'OPEN REGISTRATION';
    public const CONJOINED                  = 'CONJOINED';
}
