<?php


namespace hiqdev\rdap\core\tests\unit\Domain\Entity;


use DateTimeImmutable;
use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\Constant\Status;
use hiqdev\rdap\core\Entity\Common;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\Link;
use hiqdev\rdap\core\ValueObject\Notice;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function testLinks(): void
    {
        $link1 = new Link('scheme1');
        $link2 = new Link('scheme2');
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addLink($link1);
        $common->addLink($link2);
        $this->assertSame([$link1, $link2], $common->getLinks());
    }

    public function testNoticesAndRemarks(): void
    {
        $notice1 = new Notice('title1', 'type1', 'description1');
        $notice2 = new Notice('title2', 'type2', 'description2');
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
        $event1 = Event::occurred('action1', new DateTimeImmutable());
        $event2 = Event::occurred('action2', new DateTimeImmutable());
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
        $status1 = Status::ACTIVE();
        $status2 = Status::LOCKED();
        $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
        $common->addStatus($status1);
        $common->addStatus($status2);
        $this->assertSame([$status1, $status2], $common->getStatuses());
    }
}
