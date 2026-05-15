<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Infrastructure\Query;

use hiqdev\rdap\core\Infrastructure\Query\DomainNamesQuery;
use PHPUnit\Framework\TestCase;

class DomainNamesQueryTest extends TestCase
{
    public function testDefaultsAreNull(): void
    {
        $q = new DomainNamesQuery();
        $this->assertNull($q->getIncludeNotChanged());
        $this->assertNull($q->getLimit());
        $this->assertNull($q->getDomains());
    }

    public function testSetIncludeNotChanged(): void
    {
        $q = new DomainNamesQuery();
        $q->setIncludeNotChanged(true);
        $this->assertTrue($q->getIncludeNotChanged());

        $q->setIncludeNotChanged(false);
        $this->assertFalse($q->getIncludeNotChanged());

        $q->setIncludeNotChanged(null);
        $this->assertNull($q->getIncludeNotChanged());
    }

    public function testSetLimit(): void
    {
        $q = new DomainNamesQuery();
        $q->setLimit(100);
        $this->assertSame(100, $q->getLimit());

        $q->setLimit(null);
        $this->assertNull($q->getLimit());
    }

    public function testSetDomains(): void
    {
        $domains = ['example.com', 'example.net', 'example.org'];
        $q       = new DomainNamesQuery();
        $q->setDomains($domains);
        $this->assertSame($domains, $q->getDomains());

        $q->setDomains(null);
        $this->assertNull($q->getDomains());
    }

    public function testSetDomainsEmpty(): void
    {
        $q = new DomainNamesQuery();
        $q->setDomains([]);
        $this->assertSame([], $q->getDomains());
    }

    public function testFluentInterface(): void
    {
        $q = new DomainNamesQuery();
        $result = $q->setIncludeNotChanged(true)
                    ->setLimit(50)
                    ->setDomains(['a.com']);

        $this->assertInstanceOf(DomainNamesQuery::class, $result);
        $this->assertTrue($result->getIncludeNotChanged());
        $this->assertSame(50, $result->getLimit());
        $this->assertSame(['a.com'], $result->getDomains());
    }
}
