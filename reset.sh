#!/bin/bash

set -v
cd "${0%/*}"
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force