.DEFAULT_GOAL := help

.PHONY: test
test: ## Run tests
	./vendor/bin/phpunit tests

.PHONY: check
check: ## Run static code checks
	./vendor/bin/phpstan analyze --level max src
	./vendor/bin/phpcs --standard=PSR12 src

# From https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
