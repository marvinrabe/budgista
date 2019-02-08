# Budgista

> Keeping a Budget is easy! Open Source Budget App

[![CircleCI](https://circleci.com/gh/marvinrabe/budgista.svg?style=shield)](https://circleci.com/gh/marvinrabe/budgista)

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
