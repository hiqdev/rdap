<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\Constant;

use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\ObjectClassName;
use hiqdev\rdap\core\Domain\Constant\Relation;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Constant\Status;
use PHPUnit\Framework\TestCase;

class ConstantTest extends TestCase
{
    // --- Role ---

    public function testRoleValues(): void
    {
        $this->assertSame('registrant',     Role::REGISTRANT->value);
        $this->assertSame('technical',      Role::TECHNICAL->value);
        $this->assertSame('administrative', Role::ADMINISTRATIVE->value);
        $this->assertSame('billing',        Role::BILLING->value);
        $this->assertSame('registrar',      Role::REGISTRAR->value);
        $this->assertSame('reseller',       Role::RESELLER->value);
        $this->assertSame('abuse',          Role::ABUSE->value);
        $this->assertSame('sponsor',        Role::SPONSOR->value);
        $this->assertSame('proxy',          Role::PROXY->value);
        $this->assertSame('noc',            Role::NOC->value);
    }

    public function testRoleFromName(): void
    {
        $this->assertSame(Role::REGISTRANT,     Role::fromName('REGISTRANT'));
        $this->assertSame(Role::TECHNICAL,      Role::fromName('TECHNICAL'));
        $this->assertSame(Role::ADMINISTRATIVE, Role::fromName('ADMINISTRATIVE'));
        $this->assertSame(Role::BILLING,        Role::fromName('BILLING'));
        $this->assertSame(Role::REGISTRAR,      Role::fromName('REGISTRAR'));
    }

    public function testRoleFromInvalidNameThrows(): void
    {
        $this->expectException(\Error::class);
        Role::fromName('NONEXISTENT');
    }

    // --- Status ---

    public function testStatusValues(): void
    {
        $this->assertSame('active',               Status::OK->value);
        $this->assertSame('locked',               Status::LOCKED->value);
        $this->assertSame('inactive',             Status::INACTIVE->value);
        $this->assertSame('transfer prohibited',  Status::TRANSFERPROHIBITED->value);
        $this->assertSame('delete prohibited',    Status::DELETEPROHIBITED->value);
        $this->assertSame('renew prohibited',     Status::RENEWPROHIBITED->value);
        $this->assertSame('update prohibited',    Status::UPDATEPROHIBITED->value);
        $this->assertSame('pending delete',       Status::PENDINGDELETE->value);
        $this->assertSame('redemption period',    Status::REDEMPTIONPERIOD->value);
        $this->assertSame('server hold',          Status::SERVERHOLD->value);
    }

    public function testStatusFromName(): void
    {
        $this->assertSame(Status::OK,     Status::fromName('OK'));
        $this->assertSame(Status::LOCKED, Status::fromName('LOCKED'));
        $this->assertSame(Status::PENDINGDELETE, Status::fromName('PENDINGDELETE'));
    }

    public function testStatusFromInvalidNameThrows(): void
    {
        $this->expectException(\Error::class);
        Status::fromName('NOTASTATUS');
    }

    // --- EventAction ---

    public function testEventActionValues(): void
    {
        $this->assertSame('registration',             EventAction::REGISTRATION->value);
        $this->assertSame('last changed',             EventAction::LAST_CHANGED->value);
        $this->assertSame('expiration',               EventAction::EXPIRATION->value);
        $this->assertSame('deletion',                 EventAction::DELETION->value);
        $this->assertSame('transfer',                 EventAction::TRANSFER->value);
        $this->assertSame('registrar expiration',     EventAction::REGISTRAR_EXPIRATION->value);
        $this->assertSame('last update of RDAP database', EventAction::LAST_UPDATE_OF_RDAP_DATABASE->value);
    }

    // --- Relation ---

    public function testRelationValues(): void
    {
        $this->assertSame('registered',              Relation::REGISTERED->value);
        $this->assertSame('unregistered',            Relation::UNREGISTERED->value);
        $this->assertSame('basic',                   Relation::BASIC->value);
        $this->assertSame('conjoined',               Relation::CONJOINED->value);
        $this->assertSame('restricted registration', Relation::RESTRICTED_REGISTRATION->value);
        $this->assertSame('open registration',       Relation::OPEN_REGISTRATION->value);
    }

    // --- ObjectClassName ---

    public function testObjectClassNameValues(): void
    {
        $this->assertSame('entity',    ObjectClassName::ENTITY->value);
        $this->assertSame('nameserver', ObjectClassName::NAMESERVER->value);
        $this->assertSame('domain',    ObjectClassName::DOMAIN->value);
        $this->assertSame('autnum',    ObjectClassName::AUTNUM->value);
        $this->assertSame('ipnetwork', ObjectClassName::IPNETWORK->value);
    }
}
