start:
	@docker-compose up

stop:
	@docker-compose down

install:
	@docker-compose exec pp-back-php composer install

reset-db:
	@docker-compose exec pp-back-php bin/console doctrine:drop:database --force

update:
	@docker-compose exec pp-back-php bin/console doctrine:schema:update--force
