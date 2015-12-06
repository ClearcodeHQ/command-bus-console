<?php

namespace Clearcode\CommandBusConsole\Console\EventListener;

use Clearcode\CommandBusConsole\Bundle\Command\CommandBusHandleCommand;
use Clearcode\CommandBusConsole\CommandFormTypeMap;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class SetFormTypeOfFormBasedCommandEventListener
{
    /** @var CommandFormTypeMap */
    private $map;

    /**
     * @param CommandFormTypeMap $map
     */
    public function __construct(CommandFormTypeMap $map)
    {
        $this->map = $map;
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();

        if (!($command instanceof CommandBusHandleCommand)) {
            return;
        }

        $input = $event->getInput();
        $inputDefinition = $event->getCommand()->getDefinition();

        $command->setFormType(
            $this->map->get(
                $input->getArgument('commandName')
            )
        );

        $this->removeCommandNameFromInput($input);
        $this->removeCommandNameFromInputDefinition($inputDefinition);
    }

    /**
     * @param InputInterface $input
     */
    public function removeCommandNameFromInput(InputInterface $input)
    {
        $commandName = $input->getArgument('commandName');

        $inputReflection = new \ReflectionObject($input);
        if ($inputReflection->isSubclassOf(ArgvInput::class)) {
            $inputReflection = $inputReflection->getParentClass();
        }
        $tokensReflection = $inputReflection->getProperty('tokens');
        $tokensReflection->setAccessible(true);
        $tokens = $tokensReflection->getValue($input);
        $tokens = array_values(array_filter($tokens, function ($token) use ($commandName) {
            return $commandName !== $token;
        }));
        $tokensReflection->setValue($input, $tokens);
    }

    /**
     * @param InputDefinition $inputDefinition
     */
    public function removeCommandNameFromInputDefinition(InputDefinition $inputDefinition)
    {
        $argumentsInDefinition = $inputDefinition->getArguments();
        unset($argumentsInDefinition['commandName']);
        $inputDefinition->setArguments($argumentsInDefinition);
    }
}
