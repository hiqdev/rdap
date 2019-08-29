<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

final class IpAddresses
{
    /**
     * @var IpV4Address[]
     */
    private $v4;

    /**
     * @var IpV6Address[]
     */
    private $v6;

    /**
     * @param IpV4Address[] $v4
     * @param IpV6Address[] $v6
     */
    private function __construct(array $v4, array $v6)
    {
        $this->v4 = $v4;
        $this->v6 = $v6;
    }

    /**
     * @param IpV4Address[] $v4
     * @param IpV6Address[] $v6
     * @return self
     */
    public static function getInstanceByProtocol(array $v4, array $v6): self
    {
        return new self($v4, $v6);
    }

    /**
     * @param IpAddress[] $inetAddr
     * @return self
     */
    public static function getInstanceByInetAddr(array $inetAddr): self
    {
        /** @var IpV4Address[] $v4 */
        $v4 = [];
        /** @var IpV6Address[] $v6 */
        $v6 = [];
        foreach ($inetAddr as $address) {
            if ($address instanceof IpV4Address) {
                $v4[] = $address;
            } else if ($address instanceof IpV6Address) {
                $v6[] = $address;
            }
        }

        return new self($v4, $v6);
    }

    /**
     * @return IpV4Address[]
     */
    public function getV4(): array
    {
        return $this->v4;
    }

    /**
     * @return IpV6Address[]
     */
    public function getV6(): array
    {
        return $this->v6;
    }
}
