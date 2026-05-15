<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\SearchResult\AbstractSearchResult;
use PHPUnit\Framework\TestCase;

class SearchResultTest extends TestCase
{
    private function makeResult(array $items = []): AbstractSearchResult
    {
        return new class($items) extends AbstractSearchResult {};
    }

    public function testConstructionWithEmptyArray(): void
    {
        $result = $this->makeResult([]);
        $this->assertSame([], $result->valueSearchResults);
        $this->assertSame([], $result->rdapConformance);
    }

    public function testConstructionWithItems(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $result = $this->makeResult([$domain]);
        $this->assertCount(1, $result->valueSearchResults);
        $this->assertSame($domain, $result->valueSearchResults[0]);
    }

    public function testAddRdapConformance(): void
    {
        $result = $this->makeResult();
        $result->addRdapConformance('rdap_level_0');
        $result->addRdapConformance('icann_rdap_response_profile_1');

        $this->assertSame(
            ['rdap_level_0', 'icann_rdap_response_profile_1'],
            $result->rdapConformance
        );
    }

    public function testMultipleDomainsInResult(): void
    {
        $d1 = new Domain(DomainName::of('example.com'));
        $d2 = new Domain(DomainName::of('example.net'));
        $d3 = new Domain(DomainName::of('example.org'));

        $result = $this->makeResult([$d1, $d2, $d3]);
        $this->assertCount(3, $result->valueSearchResults);
    }
}
