docker-compose up -d

cp .env.example .env

docker-compose run composer sh -c "composer install && composer dump-autoload --optimize"
docker-compose run node sh -c "yarn install && yarn run prod"

docker-compose run php sh -c "php artisan key:generate --no-interaction"

docker-compose run -d php sh -c "php artisan queue:work redis"
docker-compose run -d php sh -c "php artisan websockets:serve"

docker-compose run php sh -c "php artisan migrate --no-interaction"
docker-compose run php sh -c "php artisan db:seed --no-interaction"
