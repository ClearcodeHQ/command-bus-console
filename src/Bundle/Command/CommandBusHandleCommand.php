<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Clearcode\CommandBusConsole\Bundle\LegacyFormHelper;
use Matthias\SymfonyConsoleForm\Console\Command\InteractiveFormContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Carbon\Carbon;

class CommandBusHandleCommand extends InteractiveFormContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    /** @var string */
    private $alias;

    /** @var string */
    private $formType;

    /** @var string */
    private $legacyFormTypeAlias;

    /**
     * @param string $alias
     * @param string $formType
     * @param string $legacyFormTypeAlias
     */
    public function __construct($alias, $formType, $legacyFormTypeAlias)
    {
        $this->alias = $alias;
        $this->formType = $formType;
        $this->legacyFormTypeAlias = $legacyFormTypeAlias;

        parent::__construct();
    }

    /** {@inheritdoc} */
    public function formType()
    {
        return LegacyFormHelper::getType($this->formType, $this->legacyFormTypeAlias);
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName(sprintf('command-bus:%s', $this->alias))
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getContainer()->get('command_bus')->handle($this->formData());
        } catch (\Exception $e) {
            return $this->handleException($output, $e);
        }

        return $this->handleSuccess($output, get_class($this->formData()));
    }

    private function handleException(OutputInterface $output, \Exception $exception)
    {
        $command = $this->formData();
        $arguments = $this->getArgumentsString($command);

        $output->writeln(sprintf(
            '<error>[%s] The command "%s" with arguments [%s] has failed to execute. Exception "%s" was thrown with message: "%s"</error>',
            Carbon::now(), get_class($command), $arguments, get_class($exception), $exception->getMessage()
        ));

        return self::ERROR_CODE;
    }

    private function handleSuccess(OutputInterface $output, $commandToLunch)
    {
        $output->writeln(sprintf('[%s] The <info>%s</info> executed with success.', Carbon::now(), $commandToLunch));

        return self::SUCCESS_CODE;
    }

    private function getArgumentsString($command)
    {
        $argumentStrings = [];

        foreach (get_object_vars($command) as $propertyName => $propertyValue) {
            $argumentStrings[] = sprintf('%s=>"%s"', $propertyName, $propertyValue);
        }

        return implode(', ', $argumentStrings);
    }
}
