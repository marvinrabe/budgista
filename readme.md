# Budgista

> Keeping a Budget is easy! Open Source Budget App

[![CircleCI](https://circleci.com/bb/marvinrabe/budgista/tree/develop.svg?style=svg&circle-token=fe9198d5d2b9a92602ea1ea275d2b1dfe5397d4f)](https://circleci.com/bb/marvinrabe/budgista/tree/develop)

## Local Development

Setup local environment with Valet: https://laravel.com/docs/5.6/valet

## Testing

We try our best to test everything we can.

### PHPUnit

Simply run:

    vendor/bin/phpunit

### Mocha

For running JavaScript tests we use Mocha. You can start the tests by running:

    cd frontend && yarn test:unit

For running tests requiring `Intl` you have to install the `full-icu` package if your Node installation does not come with it. Afterwards you have to set the environment variable `NODE_ICU_DATA` to `node_modules/full-icu`.
