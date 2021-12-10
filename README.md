# bicrave-tp

> Instant messaging application

## General considerations

This application is a draft for a real world instant messaging application.

The author doesn't pretend that his application has a very good architecture, structure, etc. Far from there: this is a
training project!

The application is based on PHP8 and Laravel. The proposed database is MariaDB, but there is no vendor-specific queries
nor raw queries.

Bootstrap5 and React are used as the front-end technologies.

Redis is used as the queue.

Message broadcasting is done via Laravel Echo and `laravel-websockets`.

## Some implemented features

### Public and private conversations

Private conversation has only two users, and it is unique. Public conversations can include almost unlimited number of
users.

### Message broadcasting

Message broadcasting is done asynchronously. New messages and conversations are dispatched to the
queue. `laravel-websockets` server is used as the Websocket server for demonstration purposes.

### SPA using React

The proposed client implementation is an SPA. There are also loading indicators and i18n.

## How to install

Run `cs.sh` or repeat `build-dev` workflow on your machine (see `.circleci/config.yml`).

### If it doesn't work:

1. Copy the `.env.example` to `.env` and configure the environment variables. Pay attention to the
   variables: `BROADCAST_DRIVER` and `QUEUE_CONNECTION`,
2. Use Docker Compose to up containers: `docker-compose up -d`.
3. Install dependencies: `docker-compose run composer sh -c "composer install && composer dump-autoload --optimize"`
   and `docker-compose run node sh -c "yarn install && yarn run prod"`.
4. Generate the application key: `php artisan key:generate --no-interaction`.
5. Run database migrations `php artisan migrate --no-interaction`. Optionally, seed the
   database: `php artisan db:seed --no-interaction`.
6. The application is hosted at `chut.test`. To access it you have to update your `hosts` or deploy it somewhere else.
7. Run queue workers: `docker-compose run -d php sh -c "php artisan queue:work redis"`.
8. Start Websocket server: `docker-compose run -d php sh -c "php artisan websockets:serve"`.
9. Profit!

### Test

Tests are run on CircleCI. To run them locally, repeat `build-dev` workflow on your machine (see `.circleci/config.yml`)
.
