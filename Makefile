project=-p myproject
start:
	@docker-compose -f docker-compose.yml $(project) up -d --remove-orphans
stop:
	@docker-compose -f docker-compose.yml $(project) down
ssh:
	@docker-compose $(project) exec backend /bin/bash

ssh-mysql:
	@docker-compose $(project) exec mysql /bin/bash

ssh-nginx:
	@docker-compose $(project) exec nginx /bin/bash

logs-nginx:
	@docker-compose logs -f nginx

exec:
	@docker-compose $(project) exec backend $$cmd

exec-bash:
	@docker-compose $(project) exec $(optionT) symfony bash -c "$(cmd)"

composer-install:
	@make exec-bach cmd="COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader"
