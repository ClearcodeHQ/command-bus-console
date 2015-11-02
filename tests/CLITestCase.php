<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class CLITestCase extends WebTestCase
{
    /** {@inheritdoc} */
    public static function getKernelClass()
    {
        include_once __DIR__ . '/App/TestKernel.php';

        return 'tests\ClearcodeHQ\CommandBusLauncherBundle\App\TestKernel';
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->prepareKernel();
    }

    /**
     * @param Command $command
     * @param array $parameters
     *
     * @return int
     */
    protected function executeCommand(Command $command, $parameters = [])
    {
        $application = new Application($this->kernel());
        $application->add($command);

        $tester = new CommandTester($command);
        $tester->execute($parameters);

        return $tester->getStatusCode();
    }

    /**
     * @return KernelInterface
     */
    private function kernel()
    {
        return static::$kernel;
    }

    private function prepareKernel()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }

        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }
}
