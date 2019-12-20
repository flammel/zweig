.DEFAULT_GOAL := help

.PHONY: test
test: ## Run tests
	./vendor/bin/phpunit tests

.PHONY: coverage
coverage: ## Run tests and generate a coverage report
	./vendor/bin/phpunit --coverage-html coverage --whitelist src tests

.PHONY: check
check: cs phpstan ## Run phpcs and phpstan

.PHONY: cs
cs: ## Find code style violations with phpcs
	./vendor/bin/phpcs --standard=PSR12 src tests

.PHONY: cbf
cbf: ## Automatically fix code style violations with phpcbf
	./vendor/bin/phpcbf --standard=PSR12 src tests

.PHONY: phpstan
phpstan: ## Run phpstan
	./vendor/bin/phpstan analyze --level max src tests

# From https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
