<?php


namespace hiqdev\rdap\core\ValueObject\Label;


class RootLabel extends Label
{
    /**
     * @var RootLabel
     */
    private static $instanse;

    public function __construct()
    {
        parent::__construct('');
        static::$instanse = new RootLabel();
    }

    /**
     * @return RootLabel
     */
    public static function getInstanse()
    {
        return self::$instanse;
    }
}
