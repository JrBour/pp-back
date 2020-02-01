start:
	@docker-compose up

stop:
	@docker-compose down

install:
	@docker-compose exec pp-back-php composer install

reset-db:
	@docker-compose exec pp-back-php bin/console d:d:d --force

update:
	@docker-compose exec pp-back-php bin/console d:s:u --force

create-database:
	@docker-compose exec pp-back-php bin/console d:c:d
