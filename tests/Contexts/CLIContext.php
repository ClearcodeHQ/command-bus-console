<?php

namespace tests\Clearcode\CommandBusConsole\Contexts;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Clearcode\CommandBusConsole\Bundle\Command\CommandBusConsoleCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use tests\Clearcode\CommandBusConsole\Bundle\App\TestKernel;

class CLIContext implements Context, SnippetAcceptingContext
{
    private $app;

    private $status;

    public function __construct()
    {
        $kernel = new TestKernel('test', false);
        $this->app = new Application($kernel);
        $this->app->setAutoExit(false);
        $this->app->add(new CommandBusConsoleCommand());
    }

    /**
     * @When I run command :command
     */
    public function iRunCommand($command)
    {
        $input = new StringInput($command);
        $output = new StreamOutput(fopen('php://memory', 'w'));

        $this->status = $this->app->run($input, $output);
    }

    /**
     * @Then command should end successfully
     */
    public function commandShouldEndSuccessfully()
    {
        Assertion::same($this->status, 0);
    }
}
