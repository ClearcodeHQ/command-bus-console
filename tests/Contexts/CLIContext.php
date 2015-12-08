<?php

namespace tests\Clearcode\CommandBusConsole\Contexts;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use tests\Clearcode\CommandBusConsole\TestKernel;
use tests\Clearcode\CommandBusConsole\Helper\ApplicationTester;
use tests\Clearcode\CommandBusConsole\Helper\StringUtil;

class CLIContext implements Context, SnippetAcceptingContext
{
    private $tester;

    public function __construct()
    {
        $kernel = new TestKernel('test', false);
        $app = new Application($kernel);
        $this->tester = new ApplicationTester($app);
    }

    /**
     * @param string $command
     *
     * @When I run command :command
     */
    public function iRunCommand($command)
    {
        $this->runCommandWithNonInteractiveInput($command);
    }

    /**
     * @param string       $command
     * @param PyStringNode $input
     *
     * @When I run command :command and provide as input
     */
    public function iRunCommandAndProvideAsInput($command, PyStringNode $input)
    {
        $this->runCommandWithInteractiveInput($command, $input);
    }

    /**
     * @Then command should end successfully
     */
    public function commandShouldEndSuccessfully()
    {
        Assertion::same($this->tester->getStatusCode(), 0);
    }

    /**
     * @Then command should end unsuccessfully
     */
    public function commandShouldEndUnsuccessfully()
    {
        Assertion::notSame($this->tester->getStatusCode(), 0);
    }

    /**
     * @Then the output should be
     *
     * @param PyStringNode $expectedOutput
     */
    public function theOutputShouldBe(PyStringNode $expectedOutput)
    {
        dump($this->getOutput());
        Assertion::same(StringUtil::removeEmptyLines($this->getOutput()), (string) $expectedOutput);
    }

    /**
     * @param PyStringNode $expectedOutput
     *
     * @When the output should contain
     */
    public function theOutputShouldContain(PyStringNode $expectedOutput)
    {
        Assertion::contains(StringUtil::removeEmptyLines($this->getOutput()), (string) $expectedOutput);
    }

    private function runCommandWithNonInteractiveInput($command)
    {
        $this->tester->run($command, array('interactive' => false, 'decorated' => false));
    }

    private function runCommandWithInteractiveInput($command, $input)
    {
        $input = str_replace('[enter]', "\n", $input);
        $this->tester->putToInputStream($input);
        $this->tester->run($command, array('interactive' => true, 'decorated' => false));
    }

    private function getOutput()
    {
        return $this->tester->getDisplay(true);
    }
}
