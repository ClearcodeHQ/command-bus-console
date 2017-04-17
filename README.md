[![Build Status](https://travis-ci.org/ClearcodeHQ/command-bus-console.svg?branch=master)](https://travis-ci.org/ClearcodeHQ/command-bus-console)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ClearcodeHQ/command-bus-console/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ClearcodeHQ/command-bus-console/?branch=master)
[![MIT License](https://img.shields.io/packagist/l/clearcode/command-bus-console.svg)](https://github.com/ClearcodeHQ/command-bus-console/blob/master/LICENSE)

# Command Bus Console

[![Join the chat at https://gitter.im/ClearcodeHQ/command-bus-console](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/ClearcodeHQ/command-bus-console?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Command Bus Console is a package exposing your command bus functionality to the CLI.
Command Bus Console is based on [Symfony Console Form](https://github.com/matthiasnoback/symfony-console-form)
and [https://github.com/SimpleBus](https://github.com/SimpleBus). 

# Installation

```console
$ composer require clearcode/command-bus-console
```

Enable bundles in the kernel of your Symfony application.

```php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new SimpleBusCommandBusBundle(), // this one you probably have already registered
            new SymfonyConsoleFormBundle(),
            new Clearcode\CommandBusConsole\Bundle\CommandBusConsoleBundle(),
        );
    }
```

# Usage

## Create and register form type for your command.

Assumed that you already have a command class and its handler class, create form type class mapping your command properties:

```php
class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'Id',
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('email', TextType::class, [
                'label' => 'email',
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SignUp::class,
        ]);
    }

    ...
}
```

And register your form type using `command_bus.type` with required attributes `command` which is FQCN of your command
and `alias` which will be used to register console command with name `command-bus:alias`.

```yaml
    form_type_service_id:
        class: Fully\Qualified\Class\Name\Of\SignUpType
        tags:
            - { name: form.type }
            - { name: command_bus.type, command: Fully\Qualified\Class\Name\Of\SignUp, alias: sign-up }
```

## Run command in interactive mode

```console
$ bin/console command-bus:sign-up
Id:
Name:
email:

[2015-12-11 10:34:55] The Fully\Qualified\Class\Name\Of\SignUp executed with success.
```

## Run command in non interactive mode

```console
$ bin/console command-bus:alias-for-command --no-interaction --id=1 --name=John --email=john@doe.com

[2015-12-11 10:34:55] The Fully\Qualified\Class\Name\Of\SignUp executed with success.
```

# To Do
- [ ] All fields should be required
- [ ] Add generating form types on the fly
- [ ] Add support for instantiating command objects via `__construct`
- [ ] Add possibility to use any command bus implementation
 - [ ] Introduce abstraction on command bus


# License

MIT, see LICENSE.
