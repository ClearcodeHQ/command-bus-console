<?php

namespace tests\ClearcodeHQ\Bundle\CommandBusLauncherBundle\App;

use ClearcodeHQ\Bundle\CommandBusLauncherBundle\CommandBusLauncherBundle;
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
            new CommandBusLauncherBundle(),
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
        return sys_get_temp_dir().'/clearcodehq_command_bus_launcher';
    }
}
