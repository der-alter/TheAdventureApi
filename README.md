# The Adventure API

Old-school RPG Mini game API

## Requirements

You need PHP up to version 8.1 and docker.

## Install

Just run `composer install`

## Dev

Run `docker compose up -d` to start services.

An [adminer](http://localhost:8080/?server=db&username=root&db=app) is available to inspect and interact with db.

The default configuration use a database named `app` and the user `root` with password `secret`.
