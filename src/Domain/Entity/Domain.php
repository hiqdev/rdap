<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\Entity;

use hiqdev\rdap\core\Domain\Constant\ObjectClassName;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Domain\Constant\Role;

/**
 * RDAP domain object as defined by RFC 9083 §5.3, representing a registered domain name
 * with nameservers, DNSSEC data, related entities, and optional redaction rules (RFC 9537).
 */
final class Domain extends Common
{
    use TopMostEntityTrait;

    /**
     * @var DomainName
     */
    private $ldhName;

    /**
     * @var PublicId[]|null
     */
    private $publicIds;

    /**
     * @var string|null a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var Variant[]|null
     */
    private $variants;

    /**
     * @var Nameserver[]|null
     */
    private $nameservers;

    /**
     * @var SecureDNS|null
     */
    private $secureDNS;

    /**
     * @var Entity[]|null
     */
    private $entities;

    /**
     * @var IPNetwork|null
     */
    private $network;

    /** @var  array */
    private $redacted;

    /** @param DomainName $ldhName Domain name; stored internally in LDH (ASCII) form */
    public function __construct(DomainName $ldhName)
    {
        parent::__construct(ObjectClassName::DOMAIN);

        $this->ldhName = $ldhName->toLDH();

        $this->secureDNS = new SecureDNS();
    }

    /**
     * @return DomainName
     */
    public function getLdhName(): DomainName
    {
        return $this->ldhName;
    }

    /** @return DomainName Unicode (U-label) representation of the domain name */
    public function getUnicodeName(): DomainName
    {
        return $this->ldhName->toUnicode();
    }

    /**
     * @return PublicId[]|null
     */
    public function getPublicIds(): ?array
    {
        return $this->publicIds;
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @return Variant[]|null
     */
    public function getVariants(): ?array
    {
        return $this->variants;
    }

    /**
     * @return Nameserver[]|null
     */
    public function getNameservers(): ?array
    {
        return $this->nameservers;
    }

    /**
     * @return SecureDNS
     */
    public function getSecureDNS(): SecureDNS
    {
        return $this->secureDNS;
    }

    /**
     * @return Entity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @return IPNetwork|null
     */
    public function getNetwork(): ?IPNetwork
    {
        return $this->network;
    }

    /**
     * @param PublicId $publicId
     * @return Domain
     */
    public function addPublicId(PublicId $publicId): Domain
    {
        if ($this->publicIds === null) {
            $this->publicIds = [];
        }
        $this->publicIds[] = $publicId;

        return $this;
    }

    /**
     * @param string $handle
     * @return Domain
     */
    public function setHandle(string $handle): Domain
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * @param Variant $variant
     * @return Domain
     */
    public function addVariant(Variant $variant): Domain
    {
        if ($this->variants === null) {
            $this->variants = [];
        }
        $this->variants[] = $variant;

        return $this;
    }

    /**
     * @param Nameserver $nameserver
     * @return Domain
     */
    public function addNameserver(Nameserver $nameserver): Domain
    {
        if ($this->nameservers === null) {
            $this->nameservers = [];
        }
        $this->nameservers[] = $nameserver;

        return $this;
    }

    /**
     * @param SecureDNS $secureDNS
     * @return Domain
     */
    public function setSecureDNS(SecureDNS $secureDNS): Domain
    {
        $this->secureDNS = $secureDNS;

        return $this;
    }

    /**
     * @param Entity $entity
     * @return Domain
     */
    public function addEntity(Entity $entity): Domain
    {
        if ($this->entities === null) {
            $this->entities = [];
        }

        $this->entities[] = $entity;

        return $this;
    }

    /**
     * @param IPNetwork $network
     * @return Domain
     */
    public function setNetwork(IPNetwork $network): Domain
    {
        $this->network = $network;

        return $this;
    }

    /** @return array RDAP redacted-fields array (RFC 9537) */
    public function getRedacted(): array
    {
        return $this->redacted ?? [];
    }

    /**
     * @param  bool|null $wp When true, adds WHOIS-privacy redaction rules for personal contact fields
     * @return self
     */
    public function setRedacted(?bool $wp = false): Domain
    {
        $this->setDefaultRedactedRules();
        if ($wp === true) {
            $this->setWPRedactedRules();
        }

        return $this;
    }

    private function setDefaultRedactedRules(): void
    {
        $this->redacted = [];
        $allowedRoles = ['registrant' => 'Registrant', 'technical' => 'Tech'];

        foreach (($this->getEntities() ?? []) as $v) {
            if ($v->getHandle() !== null || empty($v->getRoles())) {
                continue;
            }
            foreach ($v->getRoles() as $roleIndex => $role) {
                $type = $role->value;
                if (!isset($allowedRoles[$type])) {
                    continue;
                }
                $label = $allowedRoles[$type];
                $this->redacted[] = [
                    'name'     => ['type' => "Registry {$label} ID"],
                    'prePath'  => "$.entities[?(@.roles[{$roleIndex}]=='{$type}')].handle",
                    'pathLang' => 'jsonpath',
                    'method'   => 'removal',
                    'reason'   => ['description' => 'Server policy'],
                ];
            }
        }
    }

    private function setWPRedactedRules(): void
    {
        $this->redacted = $this->redacted ?: [];

        $seenRegistrant = false;
        $seenTechnical  = false;

        foreach (($this->getEntities() ?? []) as $v) {
            foreach ($v->getRoles() as $roleIndex => $role) {
                $type = $role->value;

                if ($type === 'registrant' && !$seenRegistrant) {
                    $seenRegistrant = true;
                    $base = "$.entities[?(@.roles[{$roleIndex}]=='registrant')].vcardArray[1]";

                    $this->redacted[] = $this->redactedPostPath('Registrant Name',        "{$base}[?(@[0]=='fn')][3]");
                    $this->redacted[] = $this->redactedPrePath( 'Registrant Organization', "{$base}[?(@[0]=='org')]");
                    $this->redacted[] = $this->redactedPostPath('Registrant Street',       "{$base}[?(@[0]=='adr')][3][2]");
                    $this->redacted[] = $this->redactedPostPath('Registrant City',         "{$base}[?(@[0]=='adr')][3][3]");
                    $this->redacted[] = $this->redactedPostPath('Registrant Postal Code',  "{$base}[?(@[0]=='adr')][3][5]");
                    $this->redacted[] = $this->redactedPrePath( 'Registrant Phone',        "{$base}[?(@[1].type=='voice')]");
                    $this->redacted[] = $this->redactedPrePath( 'Registrant Phone Ext',    "{$base}[?(@[1].type=='voice')]");
                    $this->redacted[] = $this->redactedPrePath( 'Registrant Fax',          "{$base}[?(@[1].type=='fax')]");
                    $this->redacted[] = $this->redactedPrePath( 'Registrant Fax Ext',      "{$base}[?(@[1].type=='fax')]");
                    $this->redacted[] = $this->redactedPostPath('Registrant Email',        "{$base}[?(@[0]=='email')][3]", 'replacementValue');
                }

                if ($type === 'technical' && !$seenTechnical) {
                    $seenTechnical = true;
                    $base = "$.entities[?(@.roles[{$roleIndex}]=='technical')].vcardArray[1]";

                    $this->redacted[] = $this->redactedPostPath('Tech Name',      "{$base}[?(@[0]=='fn')][3]");
                    $this->redacted[] = $this->redactedPrePath( 'Tech Phone',     "{$base}[?(@[1].type=='voice')]");
                    $this->redacted[] = $this->redactedPrePath( 'Tech Phone Ext', "{$base}[?(@[1].type=='voice')]");
                    $this->redacted[] = $this->redactedPostPath('Tech Email',     "{$base}[?(@[0]=='email')][3]", 'replacementValue');
                }
            }
        }
    }

    private function redactedPostPath(string $name, string $path, string $method = 'emptyValue'): array
    {
        return [
            'name'     => ['type' => $name],
            'postPath' => $path,
            'pathLang' => 'jsonpath',
            'method'   => $method,
            'reason'   => ['description' => 'Server policy'],
        ];
    }

    private function redactedPrePath(string $name, string $path): array
    {
        return [
            'name'     => ['type' => $name],
            'prePath'  => $path,
            'pathLang' => 'jsonpath',
            'method'   => 'removal',
            'reason'   => ['description' => 'Server policy'],
        ];
    }
}
