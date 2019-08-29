<?php


namespace hiqdev\rdap\core\tests\unit\Domain\Entity;


use DateTimeImmutable;
use hiqdev\rdap\core\Constant\EventAction;
use hiqdev\rdap\core\Constant\Role;
use hiqdev\rdap\core\Entity\Entity;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\PublicId;
use PHPUnit\Framework\TestCase;
use Sabre\VObject\Component\VCard;

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
        $vCard1 = new VCard([
            'FN'  => 'Cowboy Henk',
            'TEL' => '+1 555 34567 455',
            'N'   => ['Henk', 'Cowboy', '', 'Dr.', 'MD'],
        ]);
        $vCard2 = new VCard([
            'FN'  => 'Cowboy Kek',
            'TEL' => '8 800 5555 35',
            'N'   => ['Kek', 'Cowboy', '', 'Drs.', 'MD'],
        ]);
        $entity = new Entity();
        $entity->addVcard($vCard1);
        $entity->addVcard($vCard2);
        $this->assertSame([$vCard1, $vCard2], $entity->getVcardArray());
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
        $event2 = Event::occurred(EventAction::LAST_CHANGED(), new DateTimeImmutable());
        $entity = new Entity();
        $entity->addAsEventActor($event1);
        $entity->addAsEventActor($event2);
        $this->assertSame([$event1, $event2], $entity->getAsEventActor());
    }
}
