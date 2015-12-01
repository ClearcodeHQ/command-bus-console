<?php

namespace tests\Clearcode\CommandBusConsole\Bundle\App;

use Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle;
use Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle;
use SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    /** {@inheritdoc} */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SimpleBusCommandBusBundle(),
            new SymfonyConsoleFormBundle(),
            new CommandBusConsoleBundle()
        ];
    }

    /** {@inheritdoc} */
    public function getCacheDir()
    {
        return $this->tmpDir().'/cache';
    }

    /** {@inheritdoc} */
    public function getLogDir()
    {
        return $this->tmpDir().'/logs';
    }

    /** {@inheritdoc} */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }

    private function tmpDir()
    {
        return sys_get_temp_dir().'/clearcode_command_bus_console';
    }
}
