<?php

namespace tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    /** {@inheritdoc} */
    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new DoctrineBundle(),
            new SecurityBundle(),
        );
    }

    /** {@inheritdoc} */
    public function getCacheDir()
    {
        return $this->tmpDir() . '/cache';
    }

    /** {@inheritdoc} */
    public function getLogDir()
    {
        return $this->tmpDir() . '/logs';
    }

    /** {@inheritdoc} */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }
}