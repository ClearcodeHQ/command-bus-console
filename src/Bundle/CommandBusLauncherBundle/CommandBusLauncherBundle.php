<?php

namespace ClearcodeHQ\Bundle\CommandBusLauncherBundle;

use ClearcodeHQ\Bundle\CommandBusLauncherBundle\DependencyInjection\Compiler\CommandHandlersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommandBusLauncherBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandHandlersCompilerPass());
    }
}
