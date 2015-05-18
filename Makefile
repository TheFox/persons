
CP = cp -v
RM = rm -rf
CHMOD = chmod
MKDIR = mkdir -p
VENDOR = vendor
PHPUNIT = vendor/bin/phpunit
COMPOSER = ./composer.phar
COMPOSER_DEV ?= 
COMPOSER_INTERACTION ?= --no-interaction
COMPOSER_PREFER_SOURCE ?= 
PHP = php
ARTISAN = $(PHP) artisan


.PHONY: all install update refresh routes test test_phpunit test_phpunit_cc cache_clean clean

all: install

install: install/.mysql_installed .env $(VENDOR)
	$(ARTISAN) down
	$(ARTISAN) migrate
	$(ARTISAN) db:seed
	$(ARTISAN) up

update: .env $(COMPOSER)
	$(ARTISAN) down
	$(COMPOSER) selfupdate
	$(COMPOSER) update
	$(ARTISAN) migrate
	$(MAKE) cache_clean
	$(ARTISAN) up

refresh: cache_clean
	$(COMPOSER) update
	$(ARTISAN) migrate:refresh --seed

routes:
	$(ARTISAN) route:list

queue:
	$(ARTISAN) queue:listen --delay 5 --sleep 5 --tries 3

test: test_phpunit

test_phpunit: $(PHPUNIT) phpunit.xml
	TEST=true $(PHPUNIT) $(PHPUNIT_COVERAGE_HTML) $(PHPUNIT_COVERAGE_CLOVER)

test_phpunit_cc: build
	$(MAKE) test_phpunit PHPUNIT_COVERAGE_HTML="--coverage-html build/report"

cache_clean:
	$(COMPOSER) dumpautoload
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) route:clear
	$(ARTISAN) twig:clean

clean:
	$(RM) composer.lock $(COMPOSER)
	$(RM) vendor/*
	$(RM) vendor
	$(RM) .env

$(VENDOR): $(COMPOSER)
	$(COMPOSER) install $(COMPOSER_PREFER_SOURCE) $(COMPOSER_INTERACTION) $(COMPOSER_DEV)

$(COMPOSER):
	curl -sS https://getcomposer.org/installer | php
	$(CHMOD) a+rx-w,u+w $(COMPOSER)

.env:
	$(CP) .env.local .env

build:
	$(MKDIR) build
	$(MKDIR) build/logs
	$(CHMOD) a-rwx,u+rwx build

install/.mysql_installed:
	./install/mysql.sh
