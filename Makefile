# We use the target name as the environment.
ENV = $@

# Run the application
local: containers workers deps assets
	@docker-compose run php sh -c "php artisan key:generate --env=$(ENV) --no-interaction"
	@docker-compose run php sh -c "php artisan migrate --env=$(ENV) --no-interaction"
	# TODO: CORS http://chut.test

# Run tests and tear down the application
testing: containers workers deps assets
	@docker-compose run php sh -c "php artisan key:generate --env=$(ENV) --no-interaction"
	@docker-compose run php sh -c "php artisan migrate --env=$(ENV) --no-interaction"
	@docker-compose run php sh -c "php artisan db:seed --env=$(ENV) --no-interaction"
	@docker-compose run php bash -c "php artisan test"
	@docker-compose down

# Prepare environment variables
env:
	@cp .env.example .env

# Run Docker
containers: env
	@docker-compose down
	@docker-compose up -d

# Run service workers
workers: env containers deps
	@docker-compose run -d php sh -c "php artisan queue:work redis"
	@docker-compose run -d php sh -c "php artisan websockets:serve"

# Install PHP dependencies
deps: containers
	@docker-compose run composer sh -c "composer install && composer dump-autoload --optimize"

# Install NodeJS dependencies
assets: containers
	@docker-compose run node sh -c "yarn install && yarn run prod"

# Wait for the database
db: containers
	@docker-compose run php sh -c "wait-for-it.sh db:3306"
