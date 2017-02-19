
CP = cp -v
RM = rm -rfd
CHMOD = chmod
MKDIR = mkdir -p
TOUCH = touch
VENDOR = vendor
PHPUNIT = vendor/bin/phpunit
COMPOSER = ./composer.phar
COMPOSER_OPTIONS ?= --no-interaction
PHP = php
ARTISAN = $(PHP) artisan


.PHONY: all
all: install

.PHONY: install
install: install_dev

.PHONY: update
update: update_dev

.PHONY: install_dev
install_dev: install/.mysql_installed_dev .env $(VENDOR)
	$(ARTISAN) down
	$(ARTISAN) migrate
	$(ARTISAN) db:seed
	$(ARTISAN) up
	$(TOUCH) install/.installed

.PHONY: clean
clean:
	$(RM) $(COMPOSER) $(VENDOR) .env install/.mysql_installed_dev bootstrap/cache

$(VENDOR): $(COMPOSER) bootstrap/cache
	$(COMPOSER) install $(COMPOSER_OPTIONS)

$(COMPOSER):
	curl -sS https://getcomposer.org/installer | php
	$(CHMOD) u=rwx,go=rx $(COMPOSER)

.env:
	$(CP) .env.example .env

install/.mysql_installed_dev:
	./install/mysql_dev.sh

bootstrap/cache:
	$(MKDIR) $@
	$(CHMOD) +rwx $@
