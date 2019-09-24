<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use JeroenDesloovere\VCard\VCard;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testHandle(): void
    {
        $handle = 'handle';
        $entity = new Entity();
        $entity->setHandle($handle);
        $this->assertSame($handle, $entity->getHandle());
    }

    public function testVCardArray(): void
    {
        $vcard1 = new VCard();
        $vcard1->addEmail('text@example.com');
        $vcard1->addPhoneNumber('+380931234567');
        $vcard1->addName('Doe', 'John');
        $vcard1->addCompany('Acme Inc');

        $vcard2 = new VCard();
        $vcard2->addEmail('text@example.com');
        $vcard2->addPhoneNumber('+380931234567');
        $vcard2->addName('Doe', 'John');
        $vcard2->addCompany('Acme Inc');

        $entity = new Entity();
        $entity->addVcard($vcard1);
        $entity->addVcard($vcard2);
        $this->assertSame([$vcard1, $vcard2], $entity->getVcardArray());
    }

    public function testEntity(): void
    {
        $parentEntity = new Entity();
        $childEntity1 = new Entity();
        $childEntity1->setHandle('handle1');
        $childEntity2 = new Entity();
        $childEntity1->setHandle('handle2');
        $parentEntity->addEntity($childEntity1);
        $parentEntity->addEntity($childEntity2);
        $this->assertSame([$childEntity1, $childEntity2], $parentEntity->getEntities());
    }

    public function testRoles(): void
    {
        $role1 = Role::REGISTRANT();
        $role2 = Role::RESELLER();
        $entity = new Entity();
        $entity->addRole($role1);
        $entity->addRole($role2);
        $this->assertSame([$role1, $role2], $entity->getRoles());
    }

    public function testPublicIds(): void
    {
        $publicId1 = new PublicId('type1', 'identifier1');
        $publicId2 = new PublicId('type2', 'identifier2');
        $entity = new Entity();
        $entity->addPublicId($publicId1);
        $entity->addPublicId($publicId2);
        $this->assertSame([$publicId1, $publicId2], $entity->getPublicIds());
    }

    public function testAsEventActor(): void
    {
        $event1 = Event::occurred(EventAction::REGISTRATION(), new DateTimeImmutable());
        $event1->setEventActor('actor1');
        $event2 = Event::occurred(EventAction::LAST_CHANGED(), new DateTimeImmutable());
        $event2->setEventActor('actor2');
        $entity = new Entity();
        $entity->addAsEventActor($event1);
        $entity->addAsEventActor($event2);
        $this->assertSame([$event1, $event2], $entity->getAsEventActor());
    }
}
