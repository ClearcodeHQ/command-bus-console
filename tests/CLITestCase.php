<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CLITestCase extends WebTestCase
{
    /** @var int */
    protected $statusCode;
    /** @var string */
    protected $display;

    /** {@inheritdoc} */
    public static function getKernelClass()
    {
        include_once __DIR__.'/App/TestKernel.php';

        return 'tests\ClearcodeHQ\CommandBusLauncherBundle\App\TestKernel';
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->prepareKernel();
    }

    /**
     * @param Command $command
     * @param array   $parameters
     */
    protected function executeCommand(Command $command, $parameters = [])
    {
        $application = new Application(static::$kernel);
        $application->add($command);

        $tester = new CommandTester($command);
        $tester->execute($parameters);

        $this->display = $tester->getDisplay();
        $this->statusCode = $tester->getStatusCode();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->display = null;
        $this->statusCode = null;

        parent::tearDown();
    }

    protected function assertThatStatusCodeEquals($statusCode)
    {
        $this->assertEquals($statusCode, $this->statusCode);
    }

    protected function assertThatOutputWasDisplayed()
    {
        $this->assertNotEmpty($this->display);
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
