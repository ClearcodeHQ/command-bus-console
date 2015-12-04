<?php

namespace tests\Clearcode\CommandBusConsole;

use Clearcode\CommandBusConsole\ArgumentsProcessor;
use Clearcode\CommandBusConsole\CommandReflection;
use Clearcode\CommandBusConsole\ValueConverter\IntConverter;
use Clearcode\CommandBusConsole\ValueConverter\UuidConverter;
use Ramsey\Uuid\Uuid;
use tests\Clearcode\CommandBusConsole\Mocks\SignUpUser;
use tests\Clearcode\CommandBusConsole\Mocks\DummyCommandWithUuid;

class CommandReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_be_created_from_class_name()
    {
        $commandReflection = CommandReflection::fromClass(SignUpUser::class);

        \PHPUnit_Framework_Assert::assertInstanceOf(CommandReflection::class, $commandReflection);
    }

    /**
     * @test
     */
    public function it_returns_new_command_instance()
    {
        $argumentProcessor = new ArgumentsProcessor([new IntConverter()]);
        $commandReflection = CommandReflection::fromClass(SignUpUser::class);

        $commandParameters = ['Jacek Jagiello', 'j.jagiello@clearcode.cc'];
        $command = $commandReflection->createCommand($commandParameters, $argumentProcessor);

        \PHPUnit_Framework_Assert::assertInstanceOf(SignUpUser::class, $command);
        \PHPUnit_Framework_Assert::assertEquals('Jacek Jagiello', $command->fullName);
        \PHPUnit_Framework_Assert::assertTrue('j.jagiello@clearcode.cc' === $command->email);
    }

    /**
     * @test
     */
    public function it_returns_new_command_with_uuid_instance()
    {
        $argumentProcessor = new ArgumentsProcessor([new UuidConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommandWithUuid::class);

        $commandParameters = ['lorem ipsum', '1a67b1de-e3cb-471e-90d3-005341a29b3d'];
        $command = $commandReflection->createCommand($commandParameters, $argumentProcessor);

        \PHPUnit_Framework_Assert::assertInstanceOf(DummyCommandWithUuid::class, $command);
        \PHPUnit_Framework_Assert::assertEquals('lorem ipsum', $command->argument1);
        \PHPUnit_Framework_Assert::assertTrue(Uuid::fromString('1a67b1de-e3cb-471e-90d3-005341a29b3d')->equals($command->argument2));
    }

    /**
     * @test
     */
    public function it_returns_command_constructor_parameters()
    {
        $commandReflection = CommandReflection::fromClass(SignUpUser::class);

        $commandParameters = $commandReflection->parameters();

        \PHPUnit_Framework_Assert::assertEquals('fullName', $commandParameters[0]->name);
        \PHPUnit_Framework_Assert::assertEquals('email', $commandParameters[1]->name);
    }

    /**
     * @test
     * @expectedException \Clearcode\CommandBusConsole\MissingCommandArgument
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
     * @expectedException \Clearcode\CommandBusConsole\InvalidCommandArgument
     */
    public function it_does_not_returns_command_when_invalid_arguments_are_given()
    {
        $argumentProcessor = new ArgumentsProcessor([new UuidConverter()]);
        $commandReflection = CommandReflection::fromClass(DummyCommandWithUuid::class);

        $commandParameters = ['lorem ipsum', 2];
        $commandReflection->createCommand($commandParameters, $argumentProcessor);
    }
}
