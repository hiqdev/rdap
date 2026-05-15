<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;

use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Relation;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer\DomainNormalizer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DomainNormalizerTest extends TestCase
{
    private DomainNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new DomainNormalizer();
    }

    public function testSupportsDenormalizationForDomainOnly(): void
    {
        $this->assertTrue($this->normalizer->supportsDenormalization([], Domain::class));
        $this->assertFalse($this->normalizer->supportsDenormalization([], \stdClass::class));
        $this->assertFalse($this->normalizer->supportsDenormalization([], 'string'));
    }

    public function testHasCacheableSupportsMethod(): void
    {
        $this->assertTrue($this->normalizer->hasCacheableSupportsMethod());
    }

    public function testMinimalDomain(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'example.com'], Domain::class);

        $this->assertInstanceOf(Domain::class, $domain);
        $this->assertSame('example.com', (string) $domain->getLdhName());
    }

    public function testUnicodeLdhNameIsPunycoded(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'xn--e1aybc.xn--j1amh'], Domain::class);

        $this->assertSame('xn--e1aybc.xn--j1amh', (string) $domain->getLdhName());
        $this->assertSame('тест.укр', (string) $domain->getUnicodeName());
    }

    public function testHandle(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'example.com', 'handle' => 'H-123'], Domain::class);

        $this->assertSame('H-123', $domain->getHandle());
    }

    public function testLang(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'example.com', 'lang' => 'en'], Domain::class);

        $this->assertSame('en', $domain->getLang());
    }

    public function testPort43(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'example.com', 'port43' => 'whois.example.com'], Domain::class);

        $this->assertSame('whois.example.com', (string) $domain->getPort43());
    }

    public function testRdapConformance(): void
    {
        $conformance = ['rdap_level_0', 'icann_rdap_technical_implementation_guide_1'];
        $domain = $this->normalizer->denormalize(
            ['ldhName' => 'example.com', 'rdapConformance' => $conformance],
            Domain::class
        );

        $this->assertSame($conformance, $domain->getRdapConformance());
    }

    public function testPublicIds(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'   => 'example.com',
            'publicIds' => [
                ['type' => 'IANA Registrar ID', 'identifier' => '1234'],
                ['type' => 'ROID',               'identifier' => 'ABC'],
            ],
        ], Domain::class);

        $ids = $domain->getPublicIds();
        $this->assertCount(2, $ids);
        $this->assertSame('IANA Registrar ID', $ids[0]->getType());
        $this->assertSame('1234',              $ids[0]->getIdentifier());
        $this->assertSame('ROID',              $ids[1]->getType());
    }

    public function testStatus(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'status'  => ['active', 'locked'],
        ], Domain::class);

        $status = $domain->getStatus();
        $this->assertCount(2, $status);
        $this->assertSame(Status::OK,     $status[0]);
        $this->assertSame(Status::LOCKED, $status[1]);
    }

    public function testEvents(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'events'  => [
                ['eventAction' => 'registration', 'eventDate' => '2020-01-01T00:00:00Z', 'links' => []],
                ['eventAction' => 'expiration',   'eventDate' => '2025-12-31T23:59:59Z', 'links' => []],
            ],
        ], Domain::class);

        $events = $domain->getEvents();
        $this->assertCount(2, $events);
        $this->assertSame(EventAction::REGISTRATION, $events[0]->getEventAction());
        $this->assertSame('2020-01-01T00:00:00+00:00', $events[0]->getEventDate()->format('c'));
        $this->assertSame(EventAction::EXPIRATION,    $events[1]->getEventAction());
    }

    public function testEventWithActor(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'events'  => [
                ['eventAction' => 'transfer', 'eventDate' => '2021-06-15T12:00:00Z', 'eventActor' => 'registrar-1', 'links' => []],
            ],
        ], Domain::class);

        $this->assertSame('registrar-1', $domain->getEvents()[0]->getEventActor());
    }

    public function testLinks(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'links'   => [
                ['href' => 'https://example.com/domain/test', 'rel' => 'self', 'type' => 'application/rdap+json', 'value' => 'https://example.com/domain/test'],
                ['href' => 'https://iana.org/',               'title' => 'IANA'],
            ],
        ], Domain::class);

        $links = $domain->getLinks();
        $this->assertCount(2, $links);
        $this->assertSame('https://example.com/domain/test', $links[0]->getHref());
        $this->assertSame('self',                            $links[0]->getRel());
        $this->assertSame('application/rdap+json',           $links[0]->getType());
        $this->assertSame('IANA',                            $links[1]->getTitle());
    }

    public function testRemarks(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'remarks' => [
                ['title' => 'Note', 'type' => 'result set truncated', 'description' => ['line1', 'line2'], 'links' => []],
            ],
        ], Domain::class);

        $remarks = $domain->getRemarks();
        $this->assertCount(1, $remarks);
        $this->assertSame('Note',                  $remarks[0]->getTitle());
        $this->assertSame('result set truncated',  $remarks[0]->getType());
        $this->assertSame(['line1', 'line2'],       $remarks[0]->getDescription());
    }

    public function testVariants(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'  => 'example.com',
            'variants' => [
                ['relations' => ['registered', 'unregistered'], 'idnTable' => 'myTable', 'variantNames' => []],
            ],
        ], Domain::class);

        $variants = $domain->getVariants();
        $this->assertCount(1, $variants);
        $this->assertSame('myTable', $variants[0]->getIdnTable());
        $relations = $variants[0]->getRelations();
        $this->assertSame(Relation::REGISTERED,   $relations[0]);
        $this->assertSame(Relation::UNREGISTERED, $relations[1]);
    }

    public function testNameserverWithoutIpAddresses(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'     => 'example.com',
            'nameservers' => [
                ['ldhName' => 'ns1.example.com', 'objectClassName' => 'nameserver'],
            ],
        ], Domain::class);

        $ns = $domain->getNameservers()[0];
        $this->assertSame('ns1.example.com', (string) $ns->getLdhName());
        $this->assertNull($ns->getIpAddresses());
    }

    public function testNameserverWithIpAddresses(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'     => 'example.com',
            'nameservers' => [
                [
                    'ldhName'     => 'ns1.example.com',
                    'ipAddresses' => ['v4' => ['1.2.3.4'], 'v6' => ['2001:db8::1']],
                ],
            ],
        ], Domain::class);

        $ips = $domain->getNameservers()[0]->getIpAddresses();
        $this->assertNotNull($ips);
        $this->assertSame('1.2.3.4',       (string) $ips->getV4()[0]);
        $this->assertSame('2001:db8::1',   (string) $ips->getV6()[0]);
    }

    public function testNameserverWithEmptyIpAddressesObjectIsCreated(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'     => 'example.com',
            'nameservers' => [
                ['ldhName' => 'ns1.example.com', 'ipAddresses' => ['v4' => [], 'v6' => []]],
            ],
        ], Domain::class);

        $ips = $domain->getNameservers()[0]->getIpAddresses();
        $this->assertNotNull($ips);
        $this->assertSame([], $ips->getV4());
        $this->assertSame([], $ips->getV6());
    }

    public function testSecureDNS(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'   => 'example.com',
            'secureDNS' => [
                'zoneSigned'        => true,
                'delegationSigned'  => true,
                'maxSigLife'        => 604800,
                'dsData'  => [
                    [
                        'algorythm'  => 8,
                        'keyTag'     => 12345,
                        'digest'     => 'abcdef',
                        'digestType' => 2,
                        'events'     => [],
                        'links'      => [],
                    ],
                ],
                'keyData' => [
                    [
                        'algorythm' => 8,
                        'flags'     => '257',
                        'protocol'  => '3',
                        'publicKey' => 'AQAB...',
                        'events'    => [],
                        'links'     => [],
                    ],
                ],
            ],
        ], Domain::class);

        $sdns = $domain->getSecureDNS();
        $this->assertTrue($sdns->isZoneSigned());
        $this->assertTrue($sdns->isDelegationSigned());
        $this->assertSame(604800, $sdns->getMaxSigLife());

        $ds = $sdns->getDsData()[0];
        $this->assertSame(8,        $ds->getAlgorythm());
        $this->assertSame(12345,    $ds->getKeyTag());
        $this->assertSame('abcdef', $ds->getDigest());
        $this->assertSame(2,        $ds->getDigestType());

        $kd = $sdns->getKeyData()[0];
        $this->assertSame('257',    $kd->getFlags());
        $this->assertSame('3',      $kd->getProtocol());
        $this->assertSame('AQAB...', $kd->getPublicKey());
    }

    public function testEntityWithRolesAndStatus(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'  => 'example.com',
            'entities' => [
                [
                    'handle'          => 'REG-001',
                    'roles'           => ['registrant'],
                    'status'          => ['active'],
                    'entities'        => [],
                    'asEventActor'    => [],
                    'objectClassName' => 'entity',
                ],
            ],
        ], Domain::class);

        $entity = $domain->getEntities()[0];
        $this->assertSame('REG-001',            $entity->getHandle());
        $this->assertSame(Role::REGISTRANT,     $entity->getRoles()[0]);
        $this->assertSame(Status::OK,           $entity->getStatus()[0]);
    }

    public function testEntityWithVCard(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'  => 'example.com',
            'entities' => [
                [
                    'vcardArray' => [
                        'vcard',
                        [
                            ['version', [], 'text', '4.0'],
                            ['fn',      [], 'text', 'Jane Doe'],
                            ['email',   ['type' => 'INTERNET'], 'text', 'jane@example.com'],
                            ['tel',     ['type' => 'voice'],    'text', '+1234567890'],
                            ['org',     [], 'text', 'ACME'],
                        ],
                    ],
                    'entities'        => [],
                    'objectClassName' => 'entity',
                ],
            ],
        ], Domain::class);

        $vcardArray = $domain->getEntities()[0]->getVcardArray();
        $this->assertSame('vcard', $vcardArray[0]);
        $props = $vcardArray[1]->jsonSerialize();

        $byName = [];
        foreach ($props as $p) {
            $byName[$p[0]] = $p;
        }

        $this->assertSame('Jane Doe',         $byName['fn'][3]);
        $this->assertSame('jane@example.com', $byName['email'][3]);
        $this->assertSame(['type' => 'INTERNET'], $byName['email'][1]);
        $this->assertSame('+1234567890',      $byName['tel'][3]);
        $this->assertSame('ACME',             $byName['org'][3]);
    }

    public function testEntitySubEntitiesAreRecursivelyBuilt(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName'  => 'example.com',
            'entities' => [
                [
                    'handle'   => 'PARENT',
                    'entities' => [
                        ['handle' => 'CHILD', 'entities' => [], 'objectClassName' => 'entity'],
                    ],
                    'objectClassName' => 'entity',
                ],
            ],
        ], Domain::class);

        $parent = $domain->getEntities()[0];
        $this->assertSame('PARENT', $parent->getHandle());
        $this->assertCount(1, $parent->getEntities());
        $this->assertSame('CHILD', $parent->getEntities()[0]->getHandle());
    }

    public function testNetwork(): void
    {
        $domain = $this->normalizer->denormalize([
            'ldhName' => 'example.com',
            'network' => ['objectClassName' => 'ipnetwork', 'status' => ['active']],
        ], Domain::class);

        $network = $domain->getNetwork();
        $this->assertNotNull($network);
        $this->assertSame(Status::OK, $network->getStatus()[0]);
    }

    public function testMissingOptionalFieldsProduceNullProperties(): void
    {
        $domain = $this->normalizer->denormalize(['ldhName' => 'example.com'], Domain::class);

        $this->assertNull($domain->getHandle());
        $this->assertNull($domain->getLang());
        $this->assertNull($domain->getPort43());
        $this->assertNull($domain->getPublicIds());
        $this->assertNull($domain->getStatus());
        $this->assertNull($domain->getEvents());
        $this->assertNull($domain->getLinks());
        $this->assertNull($domain->getVariants());
        $this->assertNull($domain->getNameservers());
        $this->assertNull($domain->getEntities());
        $this->assertNull($domain->getNetwork());
    }
}
