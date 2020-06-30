project=-p lara6
start:
	@docker-compose -f docker-compose.yml $(project) up -d --remove-orphans
stop:
	@docker-compose -f docker-compose.yml $(project) down
ssh:
	@docker-compose $(project) exec backend /bin/bash

ssh-mysql:
	@docker-compose $(project) exec mysql /bin/bash

ssh-nginx:
	@docker-compose $(project) exec nginx /bin/sh

logs-nginx:
	@docker-compose $(project) logs -f nginx

exec:
	@docker-compose $(project) exec backend $$cmd

exec-bash:
	@docker-compose $(project) exec $(optionT) backend bash -c "$(cmd)"

composer-install:
	@make exec-bash cmd="COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader"

ide-helper:
	@make exec-bash cmd="php artisan ide-helper:generate && php artisan ide-helper:models -W && php artisan ide-helper:meta"

migrate:
	@make exec-bash cmd="php artisan migrate"
