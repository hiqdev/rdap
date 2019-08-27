<?php


namespace hiqdev\rdap\core\ValueObject;


use hiqdev\rdap\core\ValueObject\IpAddress;
use hiqdev\rdap\core\ValueObject\IpV4Address;
use hiqdev\rdap\core\ValueObject\IpV6Address;

class IpAddresses
{
    /**
     * @var string[]
     */
    private $v4;

    /**
     * @var string[]
     */
    private $v6;

    /**
     * @param string[] $v4
     * @param string[] $v6
     * @return IpAddresses
     */
    public static function getInstanceByProtocol(array $v4, array $v6): self
    {
        $self = new self();
        $self->v4 = $v4;
        $self->v6 = $v6;
        return $self;
    }

    /**
     * @param \hiqdev\rdap\core\ValueObject\IpAddress[] $inetAddr
     * @return IpAddresses
     */
    public static function getInstanceByInetAddr(array $inetAddr): self
    {
        $self = new self();
        if (empty($inetAddr)) {
            $self->v4 = [];
            $self->v6 = [];
        }
        $IpV4Array = [];
        $IpV6Array = [];
        foreach ($inetAddr as $address) {
            if ($address instanceof IpV4Address) {
                $IpV4Array[] = $address->getHostAddress();
            }
            if ($address instanceof IpV6Address) {
                $IpV6Array[] = $address->getHostAddress();
            }
        }
        $self->v4 = $IpV4Array;
        $self->v6 = $IpV6Array;
    }

    /**
     * @return string[]
     */
    public function getV4(): array
    {
        return $this->v4;
    }

    /**
     * @return string[]
     */
    public function getV6(): array
    {
        return $this->v6;
    }
}
