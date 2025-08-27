# Docker
up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose restart

logs:
	docker-compose logs -f

# Composer
install:
	docker-compose exec web composer install

update:
	docker-compose exec web composer update

# Utiles
shell:
	docker-compose exec web bash

reset:
	docker-compose down && docker-compose up -d

encode-password:
	@if [ -z "$(PWD)" ]; then \
		echo "Usage: make encode-password PWD=monMotDePasse"; \
	else \
		docker-compose exec web php src/AgnamStore/Command/EncodePassword.php "$(PWD)"; \
	fi