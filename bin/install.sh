#!/usr/bin/env bash

SCRIPT_BASEDIR=$(dirname "$0")
SYMF_ENV=${1:-prod}

which composer &> /dev/null || { echo 'ERROR: composer not found in PATH'; exit 1; }
which node &> /dev/null || { echo 'ERROR: node not found in PATH'; exit 1; }
which npm &> /dev/null || { echo 'ERROR: npm not found in PATH'; exit 1; }

# Switch to main directory.
cd "${SCRIPT_BASEDIR}/.."

if [[ ! -f .env ]]; then
    cp .env.dist .env

    echo "Please adapt .env file to modify your MySQL connection needs."
    echo "After you adapted the file, press Enter to continue this script."
    echo "I'll wait for you.."
    read
fi

set -x

# Install dependencies.
composer install --no-interaction

# Create Database if not exist.
./bin/console doctrine:database:create --if-not-exists

# Run migrations.
./bin/console doctrine:migrations:migrate --no-interaction --env ${SYMF_ENV}

# Create new admin user.
echo
echo "We will now create an admin user for you."
./bin/console fos:user:create --super-admin admin admin@localhost

# Run Fixtures.
#./bin/console doctrine:fixtures:load --no-interaction --append

# Run NPM.
node --version
npm --version
npm install
./node_modules/.bin/encore dev
