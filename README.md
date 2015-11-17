[![Build Status](https://travis-ci.org/ClearcodeHQ/command-bus-console.svg?branch=master)](https://travis-ci.org/ClearcodeHQ/command-bus-console)
[![Coverage Status](https://coveralls.io/repos/ClearcodeHQ/command-bus-console/badge.svg?branch=master&service=github)](https://coveralls.io/github/ClearcodeHQ/command-bus-console?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ClearcodeHQ/command-bus-console/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ClearcodeHQ/command-bus-console/?branch=master)
[![MIT License](https://img.shields.io/packagist/l/clearcode/command-bus-console.svg)](https://github.com/ClearcodeHQ/command-bus-console/blob/master/LICENSE)

# Command Bus Console

Command Bus Console is a package exposing your command bus functionality to the CLI.

# Installation

```
$ composer require clearcode/command-bus-console
```

Enable `Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle` in the kernel of your Symfony application.

```php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle(),
        );
    }
```

# Usage

```
$ bin/console command-bus:console YourCommandClass firstArgument secondArgument ... nthArgument
```

# License

MIT, see LICENSE.
