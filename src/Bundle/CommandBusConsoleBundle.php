<?php

namespace Clearcode\CommandBusConsole\Bundle;

use Clearcode\CommandBusConsole\Bundle\DependencyInjection\Compiler\BuildCommandFormTypeMapCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommandBusConsoleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BuildCommandFormTypeMapCompilerPass());
    }
}
