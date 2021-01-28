PHP_VERSION ?= 8.0
PHP := docker-compose run --rm php-${PHP_VERSION}

docker-build:
	docker-compose build

composer-install:
	${PHP} composer install
composer-self-update:
	${PHP} composer self-update
composer-update:
	${PHP} composer update
composer-require:
	${PHP} composer require ${PACKAGE}
composer-require-dev:
	${PHP} composer require --dev ${PACKAGE}

test: test-phpunit
test-phpunit:
	${PHP} php -v
	${PHP} php -d xdebug.mode=coverage vendor/bin/phpunit --coverage-text

qa-psalm:
	${PHP} php vendor/bin/psalm --no-cache
