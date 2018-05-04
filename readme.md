# Budgista

[![CircleCI](https://circleci.com/bb/marvinrabe/budgista/tree/develop.svg?style=svg&circle-token=fe9198d5d2b9a92602ea1ea275d2b1dfe5397d4f)](https://circleci.com/bb/marvinrabe/budgista/tree/develop)

## Local Development

Setup local environment with Valet: https://laravel.com/docs/5.6/valet

## PhpStorm

PhpStorm needs some configuration for developing Laravel applications.

### The Laravel Plugin for PhpStorm

To further enhance the Laravel experience, we can also install the Laravel Plugin. Under **Settings (Preferences) | Plugins**, click the Browse repositories… button and search for Laravel. The Install plugin button will download and install the plugin into our IDE.

Restart the IDE and enable the plugin under **Settings (Preferences) | Other Settings | Laravel Plugin | Enable Plugin for this Project**. All of a sudden, PhpStorm will know what all Laravel facades do, and provide code completion for controllers, views, routes, configuration, translations and many other things!

## Testing

We try our best to test everything we can.

### PHPUnit

Simply run:

    vendor/bin/phpunit

### Mocha

For running JavaScript tests we use Mocha. You can start the tests by running:

    yarn test

For running tests requiring `Intl` you have to install the `full-icu` package if your Node installation does not come with it. Afterwards you have to set the environment variable `NODE_ICU_DATA` to `node_modules/full-icu`.
