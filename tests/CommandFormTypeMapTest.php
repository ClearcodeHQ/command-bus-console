<?php

namespace tests\Clearcode\CommandBusConsole;

use Clearcode\CommandBusConsole\CommandFormTypeMap;

class CommandFormTypeMapTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_maps_from_command_fqcn_to_form_type_fqcn()
    {
        $sut = new CommandFormTypeMap();

        $sut->add('Fully\Qualified\Class\Name\Of\Command', 'Fully\Qualified\Class\Name\Of\Form\CommandType');

        $this->assertEquals(
            'Fully\Qualified\Class\Name\Of\Form\CommandType',
            $sut->get('Fully\Qualified\Class\Name\Of\Command')
        );
    }

    /** @test */
    public function it_maps_from_command_class_to_form_type_fqcn()
    {
        $sut = new CommandFormTypeMap();

        $sut->add('Fully\Qualified\Class\Name\Of\Command', 'Fully\Qualified\Class\Name\Of\Form\CommandType');

        $this->assertEquals(
            'Fully\Qualified\Class\Name\Of\Form\CommandType',
            $sut->get('Command')
        );
    }

    /** @test */
    public function it_maps_from_command_class_to_none()
    {
        $sut = new CommandFormTypeMap();

        $sut->add('Fully\Qualified\Class\Name\Of\Command', 'Fully\Qualified\Class\Name\Of\Form\CommandType');

        $this->assertEquals(
            null,
            $sut->get('OtherCommand')
        );
    }

    /** @test */
    public function it_maps_from_command_class_to_multiple_form_type_fqcn()
    {
        $sut = new CommandFormTypeMap();

        $sut->add('Fully\Qualified\Class\Name\Of\Command', 'Fully\Qualified\Class\Name\Of\Form\CommandType');
        $sut->add('Another\Fully\Qualified\Class\Name\Of\Command', 'Fully\Qualified\Class\Name\Of\Form\AnotherCommandType');

        $this->assertEquals(
            [
                'Fully\Qualified\Class\Name\Of\Command' => 'Fully\Qualified\Class\Name\Of\Form\CommandType',
                'Another\Fully\Qualified\Class\Name\Of\Command' => 'Fully\Qualified\Class\Name\Of\Form\AnotherCommandType',
            ],
            $sut->get('Command')
        );
    }
}
