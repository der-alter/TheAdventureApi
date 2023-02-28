# The Adventure API

Old-school RPG Mini game API

## Technical Overview

The data model is very simple as there is only one entity, the [Session](./src/Entity/Session.php).

I though that having an unique identifier for the character was unneeded, as there is a one to one relation
between the adventure and the character. So I cheated by merging the adventure id and the character id.

An adventure state is then entirely managed via the `state` field of the `session` table, which is of type `json`.

The Game is composed by a main [Adventure](./src/Game/Adventure.php) class that is the only object manipulated in the
controllers.

Most of the code in [Game/](./src/Game/) is made of mutable objects with static methods for their instantiation.

Follow-up:

- The Adventure class isn't used as a service, but it probably should transformed into one
- Point above should lead to clean up the controllers and move the persistence to the new service
- There are no functional tests
- There are no logs

## Requirements

You need PHP up to version 8.1 and docker.
You also need symfony cli and composer.

## Install

Just run `composer install`

## Dev

Run `docker compose up -d` to start services.

An [adminer](http://localhost:8080/?server=db&username=root&db=app) is available to inspect and interact with db.

The default configuration use a database named `app` and the user `root` with password `secret`.

Run `symfony console d:m:m` to run the migrations.

Reset db with (short) `sfc d:d:d --force && sfc d:d:c && sfc d:m:m`

Run `symfony serve -d` to run the app (watch logs with `symfony server:log`).

Run tests with `./vendor/bin/phpunit --testdox`

Run cs fixer with `composer cs-fix`
