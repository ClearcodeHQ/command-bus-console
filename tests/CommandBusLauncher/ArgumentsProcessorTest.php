<?php

namespace tests\ClearcodeHQ\CommandBusLauncher;

use ClearcodeHQ\CommandBusLauncher\ArgumentsProcessor;
use ClearcodeHQ\CommandBusLauncher\ValueConverter\IntConverter;
use ClearcodeHQ\CommandBusLauncher\ValueConverter\UuidConverter;
use Ramsey\Uuid\Uuid;

class ArgumentsProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArgumentsProcessor
     */
    private $sut;

    /**
     * @tests
     */
    public function it_process_transform_arguments_from_string()
    {
        $arguments = $this->sut->process(['first_arg', 'second_arg']);

        \PHPUnit_Framework_Assert::assertEquals('first_arg', $arguments[0]);
        \PHPUnit_Framework_Assert::assertEquals('second_arg', $arguments[1]);
    }

    /**
     * @tests
     */
    public function it_converts_numeric_strings_to_integer()
    {
        $arguments = $this->sut->process(['123', 'string_arg']);

        \PHPUnit_Framework_Assert::assertTrue(123 === $arguments[0]);
        \PHPUnit_Framework_Assert::assertEquals('string_arg', $arguments[1]);
    }

    /**
     * @tests
     */
    public function it_converts_uuid_like_strings_to_uuid_object()
    {
        $arguments = $this->sut->process(['b1b250a0-938a-48f6-b0ca-0aeccff1288e']);

        \PHPUnit_Framework_Assert::assertTrue(
            Uuid::fromString('b1b250a0-938a-48f6-b0ca-0aeccff1288e')->equals($arguments[0])
        );
    }

    public function setUp()
    {
        $this->sut = new ArgumentsProcessor([new IntConverter(), new UuidConverter()]);
    }
}
