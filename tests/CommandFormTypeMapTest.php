<?php

namespace tests\Clearcode\CommandBusConsole;

use Clearcode\CommandBusConsole\CommandFormTypeMap;
use Prophecy\Prophecy\ObjectProphecy;
use tests\Clearcode\CommandBusConsole\Mocks\DummyCommand;
use SimpleBus\Message\CallableResolver\CallableResolver;

class CommandFormTypeMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandFormTypeMap
     */
    private $sut;

    /**
     * @var array
     */
    private $commandFormTypes;

    /**
     * @var ObjectProphecy|FormType $formType
     */
    private $formType;

    /**
     * @test
     */
    public function it_process_command_form_types()
    {
        $this->sut->processFormTypeServices($this->commandFormTypes);

        \PHPUnit_Framework_Assert::assertEquals(
            $this->formType,
            $this->sut->get(DummyCommand::class)
        );
    }

    /**
     * @test
     * @expectedException SimpleBus\Message\CallableResolver\Exception\UndefinedCallable
     */
    public function it_throws_exception_undefined_command_is_called()
    {
        $this->sut->processFormTypeServices($this->commandFormTypes);

        $this->sut->get('undefined_command_name');
    }

    public function setUp()
    {
        /** @var ObjectProphecy|CallableResolver $resolver */
        $resolver = $this->prophesize('SimpleBus\Message\CallableResolver\CallableResolver');

        /** @var ObjectProphecy|FormType $formType */
        $formType = $this->prophesize('Symfony\Component\Form\Extension\Core\Type\FormType');
        $this->formType = $formType->reveal();

        $resolver->resolve('dummy_form_type')->willReturn($this->formType);

        $this->sut = new CommandFormTypeMap($resolver->reveal());

        $this->commandFormTypes = [
            DummyCommand::class => 'dummy_form_type'
        ];
    }
}
