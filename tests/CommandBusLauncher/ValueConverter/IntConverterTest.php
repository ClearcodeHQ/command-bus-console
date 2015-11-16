<?php

namespace tests\ClearcodeHQ\CommandBusLauncher\ValueConverter;

use ClearcodeHQ\CommandBusLauncher\ValueConverter\IntConverter;

class IntConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var IntConverter */
    private $sut;

    /**
     * @test
     */
    public function it_converts_string_to_int()
    {
        $int = $this->sut->convert('123');

        $this->assertTrue(123 === $int);
    }

    /**
     * @test
     */
    public function it_does_not_converts_non_numeric_string_to_int()
    {
        $invalidInt = $this->sut->convert('string');

        $this->assertTrue($invalidInt === null);
    }

    public function setUp()
    {
        $this->sut = new IntConverter();
    }
}
