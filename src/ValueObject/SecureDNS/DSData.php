<?php


namespace hiqdev\rdap\core\ValueObject\SecureDNS;


class DSData extends AbstractData
{
    /**
     * @var int
     */
    private $keyTag;

    /**
     * @var string
     */
    private $digest;

    /**
     * @var int
     */
    private $digestType;

    public function __construct(
        array $events,
        array $links,
        int $algorythm,
        int $keyTag,
        string $digest,
        int $digestType
    ) {
        parent::__construct($events, $links, $algorythm);
        $this->keyTag = $keyTag;
        $this->digest = $digest;
        $this->digestType = $digestType;
    }

    /**
     * @return string
     */
    public function getDigest(): string
    {
        return $this->digest;
    }

    /**
     * @return int
     */
    public function getDigestType(): int
    {
        return $this->digestType;
    }

    /**
     * @return int
     */
    public function getKeyTag(): int
    {
        return $this->keyTag;
    }
}
