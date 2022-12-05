# laminas-cli

[![Build Status](https://travis-ci.com/laminas/laminas-cli.svg?branch=master)](https://travis-ci.com/laminas/laminas-cli)
[![Coverage Status](https://coveralls.io/repos/github/laminas/laminas-cli/badge.svg?branch=master)](https://coveralls.io/github/laminas/laminas-cli?branch=master)

Command-line interface for Laminas projects

## Installation

### Via Composer

Install the library using [Composer](https://getcomposer.org):

```bash
$ composer require laminas/laminas-cli
```

## Usage

```bash
$ vendor/bin/laminas [command-name]
```

## Custom command

if you want to add any command for Laminas MVC or Mezzio application just implement normal
Symfony console command and add register the command for the cli:

```php
return [
    'laminas-cli' => [
        'commands' => [
            'package:command-name' => MyCommand::class,
        ],
    ],
];
```

Please remember that if command has some dependencies you should register also factory within
the container, for example:

```php
return [
    'dependencies' => [
        'factories' => [
            MyCommand::class => MyCommandFactory::class,
        ],
    ],
];
```
