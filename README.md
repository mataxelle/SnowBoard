# SnowBoard

## Table of contents

*  [General info](#general-info)
*  [Features](#features)
*  [Development environment](#development-environment)
*  [Install on local](#install-on-local)
*  [Install dependencies](#install-dependencies)

## General info

Project : A CRUD collaborative project, with users registration, snowboard figure post creation for partage. Include all users access and admin gestion.

## Features

### Front : users access

*  Homepage : display all figure posts ordered by latest. Can found a create figure post button if connected user.
*  Register / login page
*  Reset password
*  Profile page : simple profile page for registered users with their posts figure
*  Create / Edit figure posts form
*  Figure posts page : Figure post with form and comments
*  Contact page : public contact form for any question or subject

### Back : admin access

*  Admin / user pages : includes all CRUD actions

## Development environment

* PHP 8.1.10
* Node 18.14.2 et npm
* Symfony CLI
* Composer
* Create an mailjet account for email

## Requirements check

* symfony check:requirements

## Install on local

1. Clone the repo on your local webserver : [Repository](https://github.com/mataxelle/SnowBoard.git).

2. Make sure you have Php and composer on your computer.

3. Create a .env.local file at the root of your project, same level as .env, and configure the appropriate values for your project to run.

```
#Database standard parameters

DATABASE_URL='your database'

#Mailjet standard parameters

APP_MAILJET_KEY="your mailjet key"
APP_MAILJET_SECRET_KEY="your mailjet secret key"
APP_EMAIL_ADMIN="your email address"
```
4. Create a database and for fixtures run :

```
symfony console doctrine:fixtures:load
```
5. Try to connect as an admin with : `admin@test.com` `azertyuiop`

## Add Fixtures tests

* symfony console doctrine:fixtures:load

## Tests

* php bin/phpunit --testdox

### Start the environment

```
Composer install
npm install
npm run build
symfony server:start
```
