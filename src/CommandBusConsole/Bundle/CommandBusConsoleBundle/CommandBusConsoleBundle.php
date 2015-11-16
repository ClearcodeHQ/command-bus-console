<?php

namespace Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle;

use Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle\DependencyInjection\Compiler\CommandHandlersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommandBusConsoleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandHandlersCompilerPass());
    }
}
