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
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use JeroenDesloovere\VCard\VCard;

final class Entity extends Common
{
    public const OBJECT_CLASS_NAME = 'entity';

    /**
     * @var string|null
     *
     * DNRs and RIRs have registry-unique identifiers that
     * may be used to specifically reference an object
     * instance.  The semantics of this data type as found
     * in this document are to be a registry-unique
     * reference to the closest enclosing object where the
     * value is found.  The data type names "registryId",
     * "roid", "nic-handle", "registrationNo", etc., are
     * terms often synonymous with this data type.  In
     * this document, the term "handle" is used.  The term
     * exposed to users by clients is a presentation issue
     * beyond the scope of this document.
     */
    private $handle;

    /**
     * @var VCard[]|null a jCard with the entity's VCard information
     */
    private $vcardArray;

    /**
     * @var Role[]|null an array, each role signifying the relationship an
     * object would have with its closest containing object (see
     */
    private $roles;

    /**
     * @var Event[]|null this data structure takes the same form as the
     * events data structure (see Section 4.5), but each object in the
     * array MUST NOT have an "eventActor" member.  These objects denote
     * that the entity is an event actor for the given events.  See
     * Appendix B regarding the various ways events can be modeled.
     */
    private $asEventActor;

    /**
     * @var PublicId[]|null
     */
    private $publicIds;

    /**
     * @var Entity[] an array of entity objects as defined by this section
     */
    private $entities = [];

    public function __construct()
    {
        parent::__construct(ObjectClassName::ENTITY());
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @param string|null $handle
     */
    public function setHandle(?string $handle): void
    {
        $this->handle = $handle;
    }

    /**
     * @return VCard[]|null
     */
    public function getVcardArray(): ?array
    {
        return $this->vcardArray;
    }

    /**
     * @param VCard $vcard
     */
    public function addVcard(VCard $vcard): void
    {
        if (empty($this->vcardArray)) {
            $this->vcardArray = [];
        }
        $this->vcardArray[] = $vcard;
    }

    /**
     * @param Entity $entity
     */
    public function addEntity(Entity $entity): void
    {
        if (empty($this->entities)) {
            $this->entities = [];
        }
        $this->entities[] = $entity;
    }

    /**
     * @return Entity[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @return Role[]|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        if (empty($this->roles)) {
            $this->roles = [];
        }
        $this->roles[] = $role;
    }

    /**
     * @return Event[]|null
     */
    public function getAsEventActor(): ?array
    {
        return $this->asEventActor;
    }

    /**
     * @param Event $event
     */
    public function addAsEventActor(Event $event): void
    {
        if (empty($this->asEventActor)) {
            $this->asEventActor = [];
        }
        $this->asEventActor[] = $event;
    }

    /**
     * @return PublicId[]|null
     */
    public function getPublicIds(): ?array
    {
        return $this->publicIds;
    }

    /**
     * @param PublicId $publicId
     */
    public function addPublicId(PublicId $publicId): void
    {
        if (empty($this->publicIds)) {
            $this->publicIds = [];
        }
        $this->publicIds[] = $publicId;
    }
}
