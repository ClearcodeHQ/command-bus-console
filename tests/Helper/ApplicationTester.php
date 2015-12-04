<?php

namespace tests\Clearcode\CommandBusConsole\Helper;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class ApplicationTester
{
    /** @var Application */
    private $application;

    /** @var  StreamOutput */
    private $output;

    /** @var int */
    private $exitCode;

    /**
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;

        $this->application->setAutoExit(false);
    }

    /**
     * @param string $command
     *
     * @throws \Exception
     */
    public function run($command)
    {
        $input = new StringInput($command);
        $this->output = new StreamOutput(fopen('php://memory', 'w'));

        $this->exitCode = $this->application->run($input, $this->output);
    }

    /**
     * @return int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @return string
     */
    public function getOutputAsString()
    {
        return StringUtil::removeEmptyLines(
            $this->streamToString(
                $this->getOutputStream()
            )
        );
    }

    /**
     * @return resource
     */
    protected function getOutputStream()
    {
        $outputStream = $this->output->getStream();
        rewind($outputStream);

        return $outputStream;
    }

    /**
     * @param resource $stream
     *
     * @return string
     */
    protected function streamToString($stream)
    {
        return stream_get_contents($stream);
    }
}
