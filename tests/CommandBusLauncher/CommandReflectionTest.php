<?php

namespace tests\ClearcodeHQ\CommandBusLauncher;

use ClearcodeHQ\CommandBusLauncher\ArgumentsProcessor;
use ClearcodeHQ\CommandBusLauncher\CommandReflection;
use ClearcodeHQ\CommandBusLauncher\ValueConverter\IntConverter;
use ClearcodeHQ\CommandBusLauncher\ValueConverter\UuidConverter;
use Ramsey\Uuid\Uuid;
use tests\ClearcodeHQ\CommandBusLauncher\Mocks\DummyCommand;
use tests\ClearcodeHQ\CommandBusLauncher\Mocks\DummyCommandWithUuid;

class CommandReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_be_created_from_class_name()
    {
        $commandReflection = CommandReflection::fromClass(DummyCommand::class);

        \PHPUnit_Framework_Assert::assertInstanceOf(CommandReflection::class, $commandReflection);
    }

    /**
     * @test
     */
    public function it_returns_new_command_instance()
    {
        $argumentProcessor = new ArgumentsProcessor([new IntConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommand::class);

        $commandParameters = ['lorem ipsum', '2'];
        $command           = $commandReflection->createCommand($commandParameters, $argumentProcessor);

        \PHPUnit_Framework_Assert::assertInstanceOf(DummyCommand::class, $command);
        \PHPUnit_Framework_Assert::assertEquals('lorem ipsum', $command->argument1);
        \PHPUnit_Framework_Assert::assertTrue(2 === $command->argument2);
    }

    /**
     * @test
     */
    public function it_returns_new_command_with_uuid_instance()
    {
        $argumentProcessor = new ArgumentsProcessor([new UuidConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommandWithUuid::class);

        $commandParameters = ['lorem ipsum', '1a67b1de-e3cb-471e-90d3-005341a29b3d'];
        $command           = $commandReflection->createCommand($commandParameters, $argumentProcessor);

        \PHPUnit_Framework_Assert::assertInstanceOf(DummyCommandWithUuid::class, $command);
        \PHPUnit_Framework_Assert::assertEquals('lorem ipsum', $command->argument1);
        \PHPUnit_Framework_Assert::assertTrue(Uuid::fromString('1a67b1de-e3cb-471e-90d3-005341a29b3d')->equals($command->argument2));
    }

    /**
     * @test
     */
    public function it_returns_command_constructor_parameters()
    {
        $commandReflection = CommandReflection::fromClass(DummyCommand::class);

        $commandParameters = $commandReflection->parameters();

        \PHPUnit_Framework_Assert::assertEquals('argument1', $commandParameters[0]->name);
        \PHPUnit_Framework_Assert::assertEquals('argument2', $commandParameters[1]->name);
    }

    /**
     * @test
     * @expectedException \ClearcodeHQ\CommandBusLauncher\MissingCommandArgument
     */
    public function it_does_not_returns_command_when_arguments_are_missing()
    {
        $argumentProcessor = new ArgumentsProcessor([new UuidConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommandWithUuid::class);

        $commandParameters = [];
        $commandReflection->createCommand($commandParameters, $argumentProcessor);
    }

    /**
     * @test
     * @expectedException \ClearcodeHQ\CommandBusLauncher\InvalidCommandArgument
     */
    public function it_does_not_returns_command_when_invalid_arguments_are_given()
    {
        $argumentProcessor = new ArgumentsProcessor([new UuidConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommandWithUuid::class);

        $commandParameters = ['lorem ipsum', 2];
        $commandReflection->createCommand($commandParameters, $argumentProcessor);
    }
}
