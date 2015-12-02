<?php

namespace tests\Clearcode\CommandBusConsole\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Clearcode\CommandBusConsole\Bundle\Command\CommandBusInteractiveConsoleCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use tests\Clearcode\CommandBusConsole\Bundle\App\PrintDataCommand;
use tests\Clearcode\CommandBusConsole\Bundle\App\TestKernel;
use tests\Clearcode\CommandBusConsole\Bundle\Helper\ApplicationTester;
use tests\Clearcode\CommandBusConsole\Bundle\Helper\StringUtil;

class CommandContext implements Context, SnippetAcceptingContext
{
    /** @var Application */
    private $application;

    /** @var ApplicationTester */
    private $tester;

    public function __construct()
    {
        ini_set('date.timezone', 'UTC');

        $kernel = new TestKernel('test', true);
        $this->application = new Application($kernel);
        $this->application->add(new PrintDataCommand());
        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @When I run the command :commandName and I provide as input
     */
    public function iRunTheCommandAndIProvideAsInput($commandName, PyStringNode $input)
    {
        $this->runCommandWithInteractiveInput($commandName, $input);
    }

    /**
     * @Then the output should be
     */
    public function theOutputShouldBe(PyStringNode $expectedOutput)
    {
        Assertion::contains(StringUtil::trimLines($this->getOutput()), StringUtil::trimLines((string) $expectedOutput));
    }

    /**
     * @Then the command has finished successfully
     */
    public function theCommandHasFinishedSuccessfully()
    {
        Assertion::same($this->tester->getStatusCode(), 0);
    }

    private function runCommandWithInteractiveInput($commandName, $input)
    {
        $input = str_replace('[enter]', "\n", $input);
        $this->tester->putToInputStream($input);
        $this->tester->run(
            PrintDataCommand::COMMAND_NAME.' '.$commandName,
            ['interactive' => true, 'decorated' => false]
        );
    }

    private function getOutput()
    {
        return $this->tester->getDisplay(true);
    }
}