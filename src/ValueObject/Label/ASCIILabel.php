<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject\Label;

use http\Exception\InvalidArgumentException;

abstract class ASCIILabel extends Label
{
    /**
     * @var string[]
     */
    public static $bytes;

    public function __construct(string $label)
    {
        parent::__construct($label);
        self::$bytes = $this->getBytes();
        if (!self::checkContains($label)) {
            throw new InvalidArgumentException('wrong character in label string');
        }
    }

    /**
     * @return string
     */
    private function getBytes(): string
    {
        $res = '';
        foreach (range(32, 127) as $elem) {
            $res .= chr($elem);
        }
        return $res;
    }

    /**
     * @return bool
     */
    public static function checkContains($string): bool
    {
        foreach (str_split($string) as $char) {
            if (!strpos(self::$bytes, $char)) {
                return false;
            }
        }
        return true;
    }
}
