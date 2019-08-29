From 7cb6664820739b2261dd6b5e8bc7d29a463b1009 Mon Sep 17 00:00:00 2001
From: strorch <smy980807@ukr.net>
Date: Thu, 29 Aug 2019 18:50:42 +0300
Subject: [PATCH] fixed Event class with all tests and implemented full Domain
 serializing test

---
 src/Constant/Relation.php                     |   3 +-
 src/Entity/AutNum.php                         |   2 -
 src/ValueObject/Event.php                     |   3 +-
 tests/unit/Domain/Entity/CommonTest.php       |   5 +-
 tests/unit/Domain/Entity/DomainTest.php       |   3 +-
 tests/unit/Domain/Entity/EntityTest.php       |   5 +-
 .../Symfony/DomainSerializerTest.php          | 117 +++++++++++++++-
 .../Symfony/stub/full_domain_info.json        | 128 +++++++++++++++++-
 8 files changed, 248 insertions(+), 18 deletions(-)

diff --git a/src/Constant/Relation.php b/src/Constant/Relation.php
index 394fea5..d6a6b04 100644
--- a/src/Constant/Relation.php
+++ b/src/Constant/Relation.php
@@ -10,7 +10,8 @@
  * Class Relation
  * @package hiqdev\rdap\core\Constant
  *
- * @method static self REGISTRATION()
+ * @method static self BASIC()
+ * @method static self REGISTERED()
  * @method static self UNREGISTERED()
  * @method static self RESTRICTED_REGISTRATION()
  * @method static self OPEN_REGISTRATION()
diff --git a/src/Entity/AutNum.php b/src/Entity/AutNum.php
index ef548aa..5ccdbb5 100644
--- a/src/Entity/AutNum.php
+++ b/src/Entity/AutNum.php
@@ -5,8 +5,6 @@
 
 
 use hiqdev\rdap\core\Constant\ObjectClassName;
-use hiqdev\rdap\core\ValueObject\DomainName;
-use hiqdev\rdap\core\ValueObject\Event;
 
 final class AutNum extends Common
 {
diff --git a/src/ValueObject/Event.php b/src/ValueObject/Event.php
index 33c020e..8f5176a 100644
--- a/src/ValueObject/Event.php
+++ b/src/ValueObject/Event.php
@@ -4,7 +4,6 @@
 
 use DateTimeImmutable;
 use hiqdev\rdap\core\Constant\EventAction;
-use hiqdev\rdap\core\ValueObject\Link;
 
 final class Event
 {
@@ -30,7 +29,7 @@ private function __construct()
     {
     }
 
-    public static function occurred(string $action, DateTimeImmutable $date): self
+    public static function occurred(EventAction $action, DateTimeImmutable $date): self
     {
         $event = new self();
         $event->action = $action;
diff --git a/tests/unit/Domain/Entity/CommonTest.php b/tests/unit/Domain/Entity/CommonTest.php
index d031cec..a3668e2 100644
--- a/tests/unit/Domain/Entity/CommonTest.php
+++ b/tests/unit/Domain/Entity/CommonTest.php
@@ -5,6 +5,7 @@
 
 
 use DateTimeImmutable;
+use hiqdev\rdap\core\Constant\EventAction;
 use hiqdev\rdap\core\Constant\ObjectClassName;
 use hiqdev\rdap\core\Constant\Status;
 use hiqdev\rdap\core\Entity\Common;
@@ -41,8 +42,8 @@ public function testNoticesAndRemarks(): void
 
     public function testEvents(): void
     {
-        $event1 = Event::occurred('action1', new DateTimeImmutable());
-        $event2 = Event::occurred('action2', new DateTimeImmutable());
+        $event1 = Event::occurred(EventAction::DELETION(), new DateTimeImmutable());
+        $event2 = Event::occurred(EventAction::DELETION(), new DateTimeImmutable());
         $common = $this->getMockForAbstractClass(Common::class, [ObjectClassName::ENTITY()]);
         $common->addEvent($event1);
         $common->addEvent($event2);
diff --git a/tests/unit/Domain/Entity/DomainTest.php b/tests/unit/Domain/Entity/DomainTest.php
index b6df5f9..98e5fb3 100644
--- a/tests/unit/Domain/Entity/DomainTest.php
+++ b/tests/unit/Domain/Entity/DomainTest.php
@@ -2,6 +2,7 @@
 
 namespace hiqdev\rdap\core\tests\unit\Domain\Entity;
 
+use hiqdev\rdap\core\Constant\EventAction;
 use hiqdev\rdap\core\Constant\Status;
 use hiqdev\rdap\core\Entity\Domain;
 use hiqdev\rdap\core\Entity\Entity;
@@ -67,7 +68,7 @@ public function testSecureDNS(): void
     {
         $domain = new Domain(DomainName::of('example.com'));
         $eventArr = [
-            Event::occurred('action', new \DateTimeImmutable())
+            Event::occurred(EventAction::DELETION(), new \DateTimeImmutable())
         ];
         $linkArr = [
             new Link('scheme'),
diff --git a/tests/unit/Domain/Entity/EntityTest.php b/tests/unit/Domain/Entity/EntityTest.php
index 4f7c002..e9e27ab 100644
--- a/tests/unit/Domain/Entity/EntityTest.php
+++ b/tests/unit/Domain/Entity/EntityTest.php
@@ -5,6 +5,7 @@
 
 
 use DateTimeImmutable;
+use hiqdev\rdap\core\Constant\EventAction;
 use hiqdev\rdap\core\Constant\Role;
 use hiqdev\rdap\core\Entity\Entity;
 use hiqdev\rdap\core\ValueObject\Event;
@@ -74,8 +75,8 @@ public function testPublicIds(): void
 
     public function testAsEventActor(): void
     {
-        $event1 = Event::occurred('action1', new DateTimeImmutable());
-        $event2 = Event::occurred('action2', new DateTimeImmutable());
+        $event1 = Event::occurred(EventAction::DELETION(), new DateTimeImmutable());
+        $event2 = Event::occurred(EventAction::DELETION(), new DateTimeImmutable());
         $entity = new Entity();
         $entity->addAsEventActor($event1);
         $entity->addAsEventActor($event2);
diff --git a/tests/unit/Serialization/Symfony/DomainSerializerTest.php b/tests/unit/Serialization/Symfony/DomainSerializerTest.php
index 400b8b5..463ad9f 100644
--- a/tests/unit/Serialization/Symfony/DomainSerializerTest.php
+++ b/tests/unit/Serialization/Symfony/DomainSerializerTest.php
@@ -2,12 +2,21 @@
 
 namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;
 
+use hiqdev\rdap\core\Constant\EventAction;
+use hiqdev\rdap\core\Constant\Relation;
+use hiqdev\rdap\core\Constant\Status;
 use hiqdev\rdap\core\Entity\Domain;
+use hiqdev\rdap\core\Entity\IPNetwork;
 use hiqdev\rdap\core\Entity\Nameserver;
 use hiqdev\rdap\core\Serialization\Symfony\SymfonySerializer;
 use hiqdev\rdap\core\ValueObject\DomainName;
+use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
+use hiqdev\rdap\core\ValueObject\Event;
 use hiqdev\rdap\core\ValueObject\IpAddresses;
 use hiqdev\rdap\core\ValueObject\Link;
+use hiqdev\rdap\core\ValueObject\Notice;
+use hiqdev\rdap\core\ValueObject\PublicId;
+use hiqdev\rdap\core\ValueObject\SecureDNS;
 use PHPUnit\Framework\TestCase;
 
 class DomainSerializerTest extends TestCase
@@ -20,7 +29,35 @@ private function getSerializer(): SymfonySerializer
     public function testSerialization()
     {
         $domain = new Domain(DomainName::of('тест.укр'));
+        $this->fillDomainWithTestData($domain);
+        $json = $this->getSerializer()->serialize($domain);
+        $stubFilename = __DIR__ . '/stub/full_domain_info.json';
+        file_put_contents($stubFilename, $json);
+        $this->assertJsonStringEqualsJsonFile($stubFilename, $json);
+    }
+
+    private function fillDomainWithTestData(Domain &$domain): void
+    {
+        $this->setHandle($domain);
+        $this->addNameservers($domain);
+        $this->addVariants($domain);
+        $this->setSecureDNS($domain);
+        $this->setNetwork($domain);
+        $this->setLang($domain);
+        $this->addPublicIds($domain);
+        $this->addStatuses($domain);
+        $this->addEvents($domain);
+        $this->setPort43($domain);
+        $this->addLinks($domain);
+        $this->addRemarks($domain);
+    }
+
+    private function setHandle(Domain &$domain): void
+    {
         $domain->setHandle('AS-TEST');
+    }
+    private function addNameservers(Domain &$domain): void
+    {
         $domain->addNameserver(new Nameserver(
             DomainName::of('ns1.example.com'),
             IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
@@ -29,12 +66,78 @@ public function testSerialization()
             DomainName::of('ns2.example.com'),
             IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
         ));
-
-        $json = $this->getSerializer()->serialize($domain);
-        $result = json_decode($json, true);
-
-        $stubFilename = __DIR__ . '/stub/full_domain_info.json';
-        file_put_contents($stubFilename, $json);
-        $this->assertJsonStringEqualsJsonFile($stubFilename, $json);
+    }
+    private function addVariants(Domain &$domain): void
+    {
+        $relations = [
+            Relation::REGISTERED(),
+            Relation::UNREGISTERED(),
+        ];
+        $domain->addVariant(new Variant($relations, 'idnTable1'));
+        $domain->addVariant(new Variant($relations, 'idnTable2'));
+    }
+    private function setSecureDNS(Domain &$domain): void
+    {
+        $eventArr = [
+            Event::occurred(EventAction::DELETION(), new \DateTimeImmutable())
+        ];
+        $linkArr = [
+            new Link('scheme'),
+        ];
+        $dsData = [
+            new SecureDNS\DSData($eventArr, $linkArr, 0, 0, 'digest', 0),
+        ];
+        $keyData = [
+            new SecureDNS\KeyData($eventArr, $linkArr, 0, 'flags', 'protocol', 'pb_key'),
+        ];
+        $domain->setSecureDNS(new SecureDNS(
+            true,
+            true,
+            10,
+            $dsData,
+            $keyData
+        ));
+    }
+    private function setNetwork(Domain &$domain): void
+    {
+        $ipNetwork = new IPNetwork();
+        $ipNetwork->addStatus(Status::ACTIVE());
+        $domain->setNetwork($ipNetwork);
+    }
+    private function setLang(Domain &$domain): void
+    {
+        $domain->setLang('english');
+    }
+    private function addPublicIds(Domain &$domain): void
+    {
+        $domain->addPublicId(new PublicId('type1', 'identifier1'));
+        $domain->addPublicId(new PublicId('type2', 'identifier2'));
+        $domain->addPublicId(new PublicId('type3', 'identifier3'));
+    }
+    private function addStatuses(Domain &$domain): void
+    {
+        $domain->addStatus(Status::ACTIVE());
+        $domain->addStatus(Status::LOCKED());
+    }
+    private function addEvents(Domain &$domain): void
+    {
+        $domain->addEvent(Event::occurred(EventAction::DELETION(), new \DateTimeImmutable()));
+        $domain->addEvent(Event::occurred(EventAction::DELETION(), new \DateTimeImmutable()));
+        $domain->addEvent(Event::occurred(EventAction::DELETION(), new \DateTimeImmutable()));
+    }
+    private function setPort43(Domain &$domain): void
+    {
+        $domain->setPort43(DomainName::of('ns1.example.com'));
+    }
+    private function addLinks(Domain &$domain): void
+    {
+        $domain->addLink(new Link('scheme1'));
+        $domain->addLink(new Link('scheme2', 'user'));
+    }
+    private function addRemarks(Domain &$domain): void
+    {
+        $domain->addRemark(new Notice('tittle1', 'type1', 'description1'));
+        $domain->addRemark(new Notice('tittle2', 'type2', 'description2'));
+        $domain->addRemark(new Notice('tittle3', 'type3', 'description3'));
     }
 }
diff --git a/tests/unit/Serialization/Symfony/stub/full_domain_info.json b/tests/unit/Serialization/Symfony/stub/full_domain_info.json
index 304f4af..5d22809 100644
--- a/tests/unit/Serialization/Symfony/stub/full_domain_info.json
+++ b/tests/unit/Serialization/Symfony/stub/full_domain_info.json
@@ -1,7 +1,39 @@
 {
   "ldhName": "xn--e1aybc.xn--j1amh",
   "unicodeName": "\u0442\u0435\u0441\u0442.\u0443\u043a\u0440",
+  "publicIds": [
+    {
+      "type": "type1",
+      "identifier": "identifier1"
+    },
+    {
+      "type": "type2",
+      "identifier": "identifier2"
+    },
+    {
+      "type": "type3",
+      "identifier": "identifier3"
+    }
+  ],
   "handle": "AS-TEST",
+  "variants": [
+    {
+      "relations": [
+        "REGISTERED",
+        "UNREGISTERED"
+      ],
+      "idnTable": "idnTable1",
+      "variantNames": []
+    },
+    {
+      "relations": [
+        "REGISTERED",
+        "UNREGISTERED"
+      ],
+      "idnTable": "idnTable2",
+      "variantNames": []
+    }
+  ],
   "nameservers": [
     {
       "ldhName": "ns1.example.com",
@@ -20,5 +52,99 @@
       "objectClassName": "nameserver"
     }
   ],
-  "objectClassName": "domain"
+  "secureDNS": {
+    "dsData": [
+      {
+        "digest": "digest",
+        "digestType": 0,
+        "keyTag": 0,
+        "algorythm": 0,
+        "events": [
+          {
+            "action": "DELETION",
+            "date": "2019-08-29T15:49:26+00:00",
+            "links": []
+          }
+        ],
+        "links": [
+          "scheme:"
+        ]
+      }
+    ],
+    "keyData": [
+      {
+        "publicKey": "pb_key",
+        "flags": "flags",
+        "protocol": "protocol",
+        "algorythm": 0,
+        "events": [
+          {
+            "action": "DELETION",
+            "date": "2019-08-29T15:49:26+00:00",
+            "links": []
+          }
+        ],
+        "links": [
+          "scheme:"
+        ]
+      }
+    ],
+    "maxSigLife": 10,
+    "delegationSigned": true,
+    "zoneSigned": true
+  },
+  "network": {
+    "objectClassName": "ipnetwork",
+    "statuses": [
+      "active"
+    ]
+  },
+  "links": [
+    "scheme1:",
+    "scheme2:\/\/user@"
+  ],
+  "remarks": [
+    {
+      "title": "tittle1",
+      "type": "type1",
+      "description": "description1",
+      "links": []
+    },
+    {
+      "title": "tittle2",
+      "type": "type2",
+      "description": "description2",
+      "links": []
+    },
+    {
+      "title": "tittle3",
+      "type": "type3",
+      "description": "description3",
+      "links": []
+    }
+  ],
+  "lang": "english",
+  "objectClassName": "domain",
+  "events": [
+    {
+      "action": "DELETION",
+      "date": "2019-08-29T15:49:26+00:00",
+      "links": []
+    },
+    {
+      "action": "DELETION",
+      "date": "2019-08-29T15:49:26+00:00",
+      "links": []
+    },
+    {
+      "action": "DELETION",
+      "date": "2019-08-29T15:49:26+00:00",
+      "links": []
+    }
+  ],
+  "port43": "ns1.example.com",
+  "statuses": [
+    "active",
+    "locked"
+  ]
 }
