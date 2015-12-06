<?php

namespace Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BuildCommandFormTypeMapCompilerPass implements CompilerPassInterface
{
    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        $commandFormTypeTags = $container->findTaggedServiceIds('command.type');
        $commandFormTypeMap = $container->getDefinition('command_bus_console.command_form_type_map');

        foreach ($commandFormTypeTags as $serviceId => $tagAttributes) {
            $this->assertOnlyOneCommandTypeTagInDefinition($tagAttributes, $serviceId);

            $tagAttributes = $tagAttributes[0];
            $formType = $container->getDefinition($serviceId);

            $this->assertTaggedServiceIsFormType($formType, $serviceId);

            $this->assertTagasRequiredAttribute($tagAttributes, $serviceId);

            $commandFormTypeMap->addMethodCall('add', [
                $tagAttributes['command'],
                $formType->getClass(),
            ]);
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
                'Service with id "%s" has %d tags named "command.type", but only one is allowed.',
                $serviceId,
                count($tagAttributes)
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
    public function assertTagasRequiredAttribute($tagAttributes, $serviceId)
    {
        if (!array_key_exists('command', $tagAttributes)) {
            throw new \InvalidArgumentException(sprintf(
                'Service with id "%s" has tag "command.type" with missing attribute "command".',
                $serviceId
            ));
        }
    }
}
