.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install project
	composer install
	make fixtures

fixtures: ## Reset database and load fixtures
	bin/console doctrine:database:drop --if-exists --force
	bin/console doctrine:database:create
	bin/console doctrine:migrations:migrate --no-interaction
	bin/console doctrine:fixtures:load --no-interaction

fixtures-test: ## Reset database and load fixtures
	bin/console doctrine:database:drop --if-exists --force --env=test
	bin/console doctrine:database:create --env=test
	bin/console doctrine:migrations:migrate --no-interaction --env=test
	bin/console doctrine:fixtures:load --no-interaction --env=test

start: ## Start the web server
	symfony server:start -d --no-tls

stop: ## Stop the web server
	symfony server:stop

test: ## Behat tests
	bin/behat