<?php

namespace tests\ClearcodeHQ\CommandBusLauncherBundle;

use ClearcodeHQ\CommandBusLauncherBundle\Command\CommandLauncherCommand;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CLITestCase extends WebTestCase
{
    /** @var Client */
    private $client;

    /** @var ContainerInterface */
    private $container;

    /** {@inheritdoc} */
    public static function getKernelClass()
    {
        include_once __DIR__ . '/App/TestKernel.php';
        return 'tests\ClearcodeHQ\CommandBusLauncherBundle\App\TestKernel';
    }

    /**
     * @return Client
     */
    protected function client()
    {
        return $this->client;
    }

    /**
     * @return ContainerInterface
     */
    protected function container()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client    = $this->createClient();
        $this->container = $this->client->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->container = null;
        $this->client    = null;

        parent::tearDown();
    }

    /**
     * @param $commandName
     * @param array $arguments
     */
    protected function executeCommand($commandName, $arguments = [])
    {
        $application = new Application($this->container()->get('kernel'));

        $command = new CommandLauncherCommand();
        $application->add($command);
        $commandTester = new CommandTester($command);

        $dialog = $this->getMock('Symfony\Component\Console\Helper\DialogHelper', ['ask']);

        foreach ($arguments as $index => $argument) {
            $dialog->expects($this->at($index))
                ->method('ask')
                ->willReturn($argument);
        }

        $command->getHelperSet()->set($dialog, 'dialog');

        return $commandTester->execute(['commandName' => $commandName]);
    }
}
