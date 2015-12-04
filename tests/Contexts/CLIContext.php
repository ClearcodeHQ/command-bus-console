<?php

namespace tests\Clearcode\CommandBusConsole\Contexts;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Clearcode\CommandBusConsole\Bundle\Command\CommandBusConsoleCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use tests\Clearcode\CommandBusConsole\Bundle\App\TestKernel;
use tests\Clearcode\CommandBusConsole\Helper\ApplicationTester;

class CLIContext implements Context, SnippetAcceptingContext
{
    private $tester;

    public function __construct()
    {
        $kernel = new TestKernel('test', false);
        $app = new Application($kernel);

        $app->add(new CommandBusConsoleCommand());

        $this->tester = new ApplicationTester($app);
    }

    /**
     * @When I run command :command
     */
    public function iRunCommand($command)
    {
        $this->tester->run($command);
    }

    /**
     * @Then command should end successfully
     */
    public function commandShouldEndSuccessfully()
    {
        Assertion::same($this->tester->getExitCode(), 0);
    }

    /**
     * @Then command should end unsuccessfully
     */
    public function commandShouldEndUnsuccessfully()
    {
        Assertion::notSame($this->tester->getExitCode(), 0);
    }

    /**
     * @Then the output should be
     *
     * @param PyStringNode $expectedOutput
     */
    public function theOutputShouldBe(PyStringNode $expectedOutput)
    {
        Assertion::same($this->tester->getOutputAsString(), (string) $expectedOutput);
    }
}
