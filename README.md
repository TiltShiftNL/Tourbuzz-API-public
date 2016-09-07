# Tourbuzz API

API for the tourbuzz applications. 

## Requirements

- PHP >= 5.5
- PostgreSQL >= 9.4 

## Uses

- Slim framework 3
- Doctrine 2
- Doctrine migrations
- Guzzle 6
- ramsey/uuid
- Swiftmailer

## Install the Application

1. Copy src/settings.disp.php to src/settings.php
2. Modify settings.php
3. [Download composer](https://getcomposer.org/)
4. run composer install
5. run php vendor/bin/doctrine-migrations migrations:migrate
6. create a user: php create_user {username} {password} {mail]}

