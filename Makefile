.PHONY: help setup dev dev-ngrok ngrok ngrok-direct install pre-commit finish ci logs log-clear migrate migrate-only seed migrate-fresh migrate-rollback tinker cache-clear test test-coverage format format-check refactor refactor-check analyse db-shell db-backup db-restore clean reset reset-dev

help:
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

setup: ## Initialize project (install deps, generate key, migrate DB)
	@php -r "file_exists('.env') || copy('.env.example', '.env');"
	make install
	@php artisan key:generate --ansi
	@php artisan storage:link --ansi
	@php artisan migrate:fresh --force --ansi --seed
	npm run build
	@echo "Project successfully initialized! 🚀"


# Development
dev: ## Start all dev services (Server + Logs + Queue + Scheduler + Vite) - Press Ctrl+C to stop
	@echo "Starting development environment..."
	@npx concurrently -c "auto" \
		-n "server,app,queue,scheduler,vite" \
		--kill-others \
		"php artisan serve" \
		"php artisan pail -vv" \
		"php artisan queue:work --tries=1 --timeout=60" \
		"php artisan schedule:work" \
		"npm run dev"

dev-ngrok: ## Start all dev services with ngrok (Server + Logs + Queue + Scheduler + Vite) - Press Ctrl+C to stop
	@echo "Starting development environment with ngrok..."
	@$(MAKE) ngrok
	@npx concurrently -c "auto" \
		-n "server,app,queue,scheduler,vite" \
		--kill-others \
		"php artisan serve" \
		"php artisan pail -vv" \
		"php artisan queue:work --tries=1 --timeout=60" \
		"php artisan schedule:work" \
		"npm run dev"

ngrok: ## Start ngrok in a new tmux pane in current session
	@if ! command -v tmux >/dev/null 2>&1; then \
		echo "tmux is required for make ngrok (install with: brew install tmux)"; \
		exit 1; \
	fi
	@if pgrep -f "ngrok http" >/dev/null 2>&1; then \
		echo "ngrok appears to already be running."; \
		exit 0; \
	fi
	@if [ -n "$$TMUX" ]; then \
		tmux split-window -v "$(MAKE) ngrok-direct"; \
		echo "ngrok started in a new tmux pane."; \
	else \
		echo "No active tmux session found."; \
		echo "Run this command from inside tmux to open ngrok in a new pane."; \
		echo "Fallback: tmux new-session -s ngrok \"$(MAKE) ngrok-direct\""; \
		exit 1; \
	fi

ngrok-direct: ## Open a default ngrok tunnel on app port (foreground)
	@PORT=$$(php -r '$$port = 8000; if (file_exists(".env")) { foreach (file(".env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $$line) { if (str_starts_with(trim($$line), "APP_PORT=")) { $$value = trim(substr(trim($$line), 9)); if ($$value !== "") { $$port = (int) $$value; } break; } } } echo $$port;'); \
		echo "Starting ngrok tunnel on port $$PORT..."; \
		ngrok http $$PORT

install: ## Install all dependencies
	git submodule update --init
	composer install
	npm install
	@echo "Dependencies installed!"

pre-commit: ## Quick formatting-only pass before committing (see 'finish' for the full post-feature check)
	make refactor
	make format

finish: ## Run after finishing a feature: refactor (PHP), format (Blade/Tailwind), analyse, then test (AGENTS.md order)
	make refactor
	npm run format
	make analyse
	make test

ci: ## Check-only pass for CI/pre-push - fails on any pending change, fixes nothing
	make format-check
	make refactor-check
	make analyse
	make test

# Logs
logs: ## Show Laravel logs (pail)
	@php artisan pail -vv

log-clear: ## Clear Laravel logs
	@truncate -s 0 storage/logs/*.log 2>/dev/null || true
	@echo "Laravel logs cleared"

migrate: ## Run migrations
	@php artisan migrate --seed

migrate-only: ## Run migrations only (no seeders)
	@php artisan migrate --ansi

seed: ## Run seeders
	@php artisan db:seed

migrate-fresh: ## Fresh migrations
	@php artisan migrate:fresh --force --ansi --seed

migrate-rollback: ## Rollback migrations
	@php artisan migrate:rollback

tinker: ## Open tinker
	@php artisan tinker

cache-clear: ## Clear all cache
	@php artisan cache:clear
	@php artisan config:clear
	@php artisan route:clear
	@php artisan view:clear
	@php artisan optimize:clear
	@composer dump-autoload
	@echo "All caches cleared!"

# Testing
test: ## Run tests (MariaDB config comes from phpunit.xml)
	@php artisan config:clear --ansi
	@./vendor/bin/pest --parallel

test-coverage: ## Run tests with coverage
	@./vendor/bin/pest --parallel --coverage

format: ## Run code formatter
	./vendor/bin/pint
	npm run format

format-check: ## Test code formatting
	./vendor/bin/pint --test
	npm run format:check

refactor: ## Run Rector, then Pint (Rector rewrites code, Pint formats the result)
	./vendor/bin/rector
	./vendor/bin/pint

refactor-check: ## Check for pending Rector changes without writing them
	./vendor/bin/rector --dry-run

analyse: ## Run static analysis
	./vendor/bin/phpstan analyse --memory-limit=2G

# Database
db-shell: ## Open MariaDB shell
	@mariadb -h $${DB_HOST:-localhost} -P $${DB_PORT:-3306} -u $${DB_USERNAME:-compact} -p$${DB_PASSWORD:-compact} $${DB_DATABASE:-compact}

db-backup: ## Backup MariaDB database to ./backups/
	@mkdir -p backups
	@echo "Creating database backup..."
	@mariadb-dump --single-transaction --routines -h $${DB_HOST:-localhost} -P $${DB_PORT:-3306} -u $${DB_USERNAME:-compact} -p$${DB_PASSWORD:-compact} $${DB_DATABASE:-compact} > backups/database-backup-$$(date +%Y%m%d-%H%M%S).sql
	@echo "Backup completed! Check ./backups/ directory"

db-restore: ## Restore database from backup (usage: make db-restore file=database-backup-20240115-120000.sql)
	@if [ -z "$(file)" ]; then \
		echo "Error: Please specify backup file. Usage: make db-restore file=database-backup-20240115-120000.sql"; \
		exit 1; \
	fi
	@echo "Restoring database from $(file)..."
	@mariadb -h $${DB_HOST:-localhost} -P $${DB_PORT:-3306} -u $${DB_USERNAME:-compact} -p$${DB_PASSWORD:-compact} $${DB_DATABASE:-compact} < backups/$(file)
	@echo "Database restored successfully!"

# Maintenance
clean: ## Clean local artifacts (⚠️ DELETES DATABASE, node_modules, vendor!)
	@rm -rf node_modules vendor public/build
	@echo "Local artifacts cleaned!"

reset: ## Complete reset (⚠️ DELETES DATABASE!)
	make clean
	make setup
	@echo "Project reset complete!"

reset-dev: ## Complete reset and start dev environment
	make reset
	make dev
