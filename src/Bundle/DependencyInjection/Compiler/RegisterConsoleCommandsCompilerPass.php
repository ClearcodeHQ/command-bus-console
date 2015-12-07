<?php

namespace Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Clearcode\CommandBusConsole\Bundle\Command\CommandBusHandleCommand;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterConsoleCommandsCompilerPass implements CompilerPassInterface
{
    const TAG = 'command_bus.type';

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $commandFormTypeTags = $container->findTaggedServiceIds(self::TAG);

        foreach ($commandFormTypeTags as $formTypeId => $formTypeTagAttributes) {
            $formTypeDefinition = $container->getDefinition($formTypeId);

            $this->assertOnlyOneCommandTypeTagInDefinition($formTypeTagAttributes, $formTypeId);
            $this->assertTaggedServiceIsFormType($formTypeDefinition, $formTypeId);
            $this->assertTagsRequiredAttribute($formTypeTagAttributes[0], $formTypeId);

            $container->setDefinition(
                sprintf('command_bus_console.%s', $formTypeTagAttributes[0]['alias']),
                (new Definition())
                    ->setClass(CommandBusHandleCommand::class)
                    ->addArgument($formTypeTagAttributes[0]['alias'])
                    ->addArgument($formTypeDefinition->getClass())
                    ->addTag('console.command')
            );
        }
    }

    /**
     * @param array  $tagAttributes
     * @param string $serviceId
     *
     * @throws \InvalidArgumentException
     */
    private function assertOnlyOneCommandTypeTagInDefinition($tagAttributes, $serviceId)
    {
        if (1 < count($tagAttributes)) {
            throw new \InvalidArgumentException(sprintf(
                'Service with id "%s" has %d tags named "%s", but only one is allowed.',
                $serviceId,
                count($tagAttributes),
                self::TAG
            ));
        }
    }

    /**
     * @param Definition $formType
     * @param string     $serviceId
     *
     * @throws \InvalidArgumentException
     */
    public function assertTaggedServiceIsFormType(Definition $formType, $serviceId)
    {
        if (!$formType->hasTag('form.type')) {
            throw new \InvalidArgumentException(sprintf(
                'Service with id "%s" has to be tagged with "form.type".',
                $serviceId
            ));
        }
    }

    /**
     * @param array  $tagAttributes
     * @param string $serviceId
     *
     * @throws \InvalidArgumentException
     */
    public function assertTagsRequiredAttribute($tagAttributes, $serviceId)
    {
        if (!array_key_exists('command', $tagAttributes)) {
            throw new \InvalidArgumentException(sprintf(
                'Service with id "%s" has tag "%s" with missing attribute "command".',
                $serviceId,
                self::TAG
            ));
        }

        if (!array_key_exists('alias', $tagAttributes)) {
            throw new \InvalidArgumentException(sprintf(
                'Service with id "%s" has tag "%s" with missing attribute "alias".',
                $serviceId,
                self::TAG
            ));
        }
    }
}
