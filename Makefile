
CP = cp -v
RM = rm -rf
CHMOD = chmod
MKDIR = mkdir -p
TOUCH = touch
VENDOR = vendor
PHPUNIT = vendor/bin/phpunit
COMPOSER = ./composer.phar
COMPOSER_DEV ?= 
COMPOSER_INTERACTION ?= --no-interaction
COMPOSER_PREFER_SOURCE ?= 
PHP = php
ARTISAN = $(PHP) artisan


.PHONY: all install install_dev install_prod update update_dev update_prod cache_clean clean

all: install

install: install_dev

update: update_dev

install_dev: install/.mysql_installed_dev .env $(VENDOR)
	$(ARTISAN) down
	$(ARTISAN) migrate
	$(ARTISAN) db:seed
	$(ARTISAN) up
	$(TOUCH) install/.installed

install_prod: $(VENDOR)
	$(ARTISAN) down
	$(ARTISAN) migrate --force
	$(ARTISAN) up
	$(TOUCH) install/.installed

update_dev: .env $(COMPOSER)
	$(COMPOSER) selfupdate
	$(COMPOSER) update
	$(ARTISAN) migrate:refresh --seed
	$(MAKE) cache_clean

update_prod: $(COMPOSER)
	$(ARTISAN) down
	$(COMPOSER) selfupdate
	$(COMPOSER) update
	$(ARTISAN) migrate --force
	$(MAKE) cache_clean
	$(ARTISAN) up

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
	$(RM) install/.mysql_installed_dev

$(VENDOR): $(COMPOSER)
	$(COMPOSER) install $(COMPOSER_PREFER_SOURCE) $(COMPOSER_INTERACTION) $(COMPOSER_DEV)

$(COMPOSER):
	curl -sS https://getcomposer.org/installer | php
	$(CHMOD) u=rwx,go=rx $(COMPOSER)

.env:
	$(CP) .env.local .env

build:
	$(MKDIR) build
	$(MKDIR) build/logs
	$(CHMOD) u=rwx,go-rwx build

install/.mysql_installed_dev:
	./install/mysql_dev.sh
