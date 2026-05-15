<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\SymfonySerializer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SymfonySerializerTest extends TestCase
{
    private SymfonySerializer $serializer;

    protected function setUp(): void
    {
        $this->serializer = new SymfonySerializer();
    }

    public function testSerializeReturnJsonString(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $json = $this->serializer->serialize($domain);

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertSame('domain', $decoded['objectClassName']);
        $this->assertSame('example.com', $decoded['ldhName']);
    }

    public function testDeserializeReturnsDomainInstance(): void
    {
        $json = json_encode(['ldhName' => 'example.com', 'objectClassName' => 'domain']);
        $result = $this->serializer->deserialize($json, Domain::class);

        $this->assertInstanceOf(Domain::class, $result);
        $this->assertSame('example.com', (string) $result->getLdhName());
    }

    public function testDeserializeThrowsWhenTypeIsNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->serializer->deserialize('{}', null);
    }

    public function testSerializeThenDeserializeRoundTrip(): void
    {
        $original = new Domain(DomainName::of('round-trip.example'));
        $json = $this->serializer->serialize($original);
        $restored = $this->serializer->deserialize($json, Domain::class);

        $this->assertJsonStringEqualsJsonString($json, $this->serializer->serialize($restored));
    }
}
