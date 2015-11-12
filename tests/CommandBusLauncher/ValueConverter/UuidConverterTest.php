<?php

namespace tests\ClearcodeHQ\CommandBusLauncher\ValueConverter;

use ClearcodeHQ\CommandBusLauncher\ValueConverter\UuidConverter;
use Ramsey\Uuid\Uuid;

class UuidConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var UuidConverter */
    private $sut;

    /**
     * @test
     */
    public function it_converts_string_uuid()
    {
        $uuid = $this->sut->convert('9d3e2d0a-f4d0-496d-9a5f-a00fe99b2053');

        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertTrue(Uuid::fromString('9d3e2d0a-f4d0-496d-9a5f-a00fe99b2053')->equals($uuid));
    }

    /**
     * @test
     */
    public function it_does_not_converts_invalid_string_to_uuid()
    {
        $uuid = $this->sut->convert('9d3efe99b2053');

        $this->assertTrue($uuid === null);
    }

    public function setUp()
    {
        $this->sut = new UuidConverter();
    }
}
