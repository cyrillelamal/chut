# chut

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

Use `make`.

```shell
# You can run a local copy of the application using the `local` target.
make local

# Or you can just run tests and tear down the application after that.
make testing
```

The local copy of the application is available at [http://chut.test](http://chut.test), so you have to refine
your `hosts` file or change the nginx config ([docker/nginx/chut.conf](docker/nginx/chut.conf)) to be able to access the
application.

### Test

Tests are run on CircleCI. You can also run `make testing` to run them locally.

### Documentation

You can also build Swagger documentation. To do it, point your openapi script to the `app` directory.
