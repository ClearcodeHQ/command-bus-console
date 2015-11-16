<?php

require_once __DIR__.'/bootstrap.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use examples\Clearcode\CommandBusConsole\App\AppKernel;
use examples\Clearcode\CommandBusConsole\Bundle\Command\RunInteractiveCommand;

\Symfony\Component\Debug\Debug::enable();

$kernel = new AppKernel('prod', true);

$app = new Application($kernel);

$app->add(new RunInteractiveCommand());

$app->run();
