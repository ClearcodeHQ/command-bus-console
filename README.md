[![Build Status](https://travis-ci.org/ClearcodeHQ/command-bus-console.svg?branch=master)](https://travis-ci.org/ClearcodeHQ/command-bus-console)
[![Coverage Status](https://coveralls.io/repos/ClearcodeHQ/command-bus-console/badge.svg?branch=master&service=github)](https://coveralls.io/github/ClearcodeHQ/command-bus-console?branch=master)
[![MIT License](https://img.shields.io/packagist/l/clearcode/command-bus-console.svg)](https://github.com/ClearcodeHQ/command-bus-console/blob/master/LICENSE)

# Command Bus Console

Command Bus Console is a package exposing your command bus functionality to the CLI.

# Installation

```console
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

```console
$ bin/console command-bus:console YourCommandClass firstArgument secondArgument ... nthArgument
```

# License

MIT, see LICENSE.

# To-Do

## Use Matthias Noback's [symfony-console-form] to implement interactive mode.
Proof of concept is available in ```examples``` directory.

And it can be run as here:

```console
    $ php examples/console.php run:interactive
```

## Examples of usage

#### Non-interactive mode.
```console
    $ bin/console command-bus:handle SignUp john.doe john.doe@example.com 1985-06-24
    [2015-11-7 13:43:24] Command Fully\Qualified\Class\Name\Of\SignUp was handled.
```

#### Non-interactive mode with more than one command of the same name.
```console
    $ bin/console command-bus:handle SignUp john.doe john.doe@example.com 1985-06-24
    [2015-11-7 13:43:24][Error: 1] There is more than one command named "SignUp".
```

#### Non-interactive mode with command FQCN.
```console
    $ bin/console command-bus:handle Fully\Qualified\Class\Name\Of\SignUp john.doe john.doe@example.com 1985-06-24
    [2015-11-7 13:43:24] Command Fully\Qualified\Class\Name\Of\SignUp was handled.
```

#### Interactive mode.
```console
    $ bin/console command-bus:handle SignUp
    Username: john.doe
    Email: john.doe@example.com
    Date of birth: 1985-06-24
    [2015-11-7 13:43:24] Command Fully\Qualified\Class\Name\Of\SignUp was handled.
```

#### Interactive mode with more than one command of the same name.
```console
    $ bin/console command-bus:handle SignUp
    There are 3 "SignUp" commands:
    :
        [1] Domain\A\Context\SignUp
        [2] Domain\B\Context\SignUp
        [3] Domain\C\Context\SignUp
    > 2
    Username: john.doe
    Email: john.doe@example.com
    Date of birth: 1985-06-24
    [2015-11-7 13:43:24] Command Domain\B\Context\SignUp was handled.
```

#### Interactive mode with choice arguments.
```console
    $ bin/console command-bus:handle SignUp
    Username: john.doe
    Email: john.doe@example.com
    :
        ...
        [1984] 1984
        [1985] 1985
        [1986] 1986
        ...
    > 1985
    :
        ...
        [5 ] May
        [6 ] Jun
        [7 ] Jul
        ...
    > 6
    :
        ...
        [23] 23
        [24] 24
        [25] 25
        ...
    > 24
    [2015-11-7 13:43:24] Command Fully\Qualified\Class\Name\Of\SignUp was handled.
```
#### Interactive with default values.
```console
    $ bin/console command-bus:handle Pay
    Transaction id [91c48d9e-440a-4178-8463-c3b0e440862b]:
    Amount: 99.00
    Currency: PLN
    [2015-11-7 13:43:24] Command Fully\Qualified\Class\Name\Of\Pay was handled.
```