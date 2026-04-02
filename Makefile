include .env
export

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

restart:
	docker compose down
	docker compose up -d

bash:
	docker exec -it $(APP_CONTAINER) bash

composer-install:
	docker exec -it $(APP_CONTAINER) composer install

symfony-install:
	docker exec -it $(APP_CONTAINER) composer create-project symfony/skeleton .

doctrine-install:
	docker exec -it $(APP_CONTAINER) composer require symfony/orm-pack
	docker exec -it $(APP_CONTAINER) composer require --dev symfony/maker-bundle

db-create:
	docker exec -it $(APP_CONTAINER) php bin/console doctrine:database:create

migration:
	docker exec -it $(APP_CONTAINER) php bin/console make:migration

migrate:
	docker exec -it $(APP_CONTAINER) php bin/console doctrine:migrations:migrate

test:
	docker exec -it $(APP_CONTAINER) php bin/phpunit

qa:
	docker exec -it $(APP_CONTAINER) php vendor/bin/phpstan analyse
	docker exec -it $(APP_CONTAINER) php vendor/bin/php-cs-fixer fix

logs:
	docker compose logs -f

validator-install:
	docker exec -it $(APP_CONTAINER) composer require symfony/validator

uuid-install:
	docker exec -it $(APP_CONTAINER) composer require ramsey/uuid

monolog-install:
	docker exec -it $(APP_CONTAINER) composer require symfony/monolog-bundle