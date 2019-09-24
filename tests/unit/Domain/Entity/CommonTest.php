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
use hiqdev\rdap\core\Domain\Constant\ObjectClassName;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Common;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function testLinks(): void
    {
        $link1 = new Link('kek.ua');
        $link1->setType('application/json');
        $link1->setTitle('title');
        $link2 = new Link('kek.ua');
        $link2->setType('application/json');
        $link2->setTitle('title');
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addLink($link1);
        $common->addLink($link2);
        $this->assertSame([$link1, $link2], $common->getLinks());
    }

    public function testNoticesAndRemarks(): void
    {
        $notice1 = new Notice('title1', 'type1', ['description1']);
        $notice2 = new Notice('title2', 'type2', ['description2']);
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addNotice($notice1);
        $common->addNotice($notice2);
        $this->assertSame([$notice1, $notice2], $common->getNotices());
        $common->addRemark($notice1);
        $common->addRemark($notice2);
        $this->assertSame([$notice1, $notice2], $common->getRemarks());
    }

    public function testEvents(): void
    {
        $eventActor1 = 'actor1';
        $eventActor2 = 'actor2';
        $link1 = new Link('google.com');
        $link2 = new Link('google1.com');

        $event1 = Event::occurred(EventAction::REGISTRATION(), new DateTimeImmutable());
        $event1->setEventActor($eventActor1);
        $event1->addLink($link1);
        $event1->addLink($link2);
        $this->assertSame($eventActor1, $event1->getEventActor());
        $this->assertSame([$link1, $link2], $event1->getLinks());

        $event2 = Event::occurred(EventAction::LAST_CHANGED(), new DateTimeImmutable());
        $event2->addLink($link2);
        $event2->setEventActor($eventActor2);
        $this->assertSame($eventActor2, $event2->getEventActor());
        $this->assertSame([$link2], $event2->getLinks());

        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addEvent($event1);
        $common->addEvent($event2);
        $this->assertSame([$event1, $event2], $common->getEvents());
    }

    public function testPort43(): void
    {
        $port43 = DomainName::of('domain.com');
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->setPort43($port43);
        $this->assertSame($port43, $common->getPort43());
    }

    public function testLang(): void
    {
        $lang = 'lang';
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->setLang($lang);
        $this->assertSame($lang, $common->getLang());
    }

    public function testStatuses(): void
    {
        $status1 = Status::OK();
        $status2 = Status::LOCKED();
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addStatus($status1);
        $common->addStatus($status2);
        $this->assertSame([$status1, $status2], $common->getStatuses());
    }

    public function testRdapConformance(): void
    {
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $newConf = 'rdap_level_1';
        $common->addRdapConformance($newConf);
        $this->assertContains($newConf, $common->getRdapConformance());
    }
}
