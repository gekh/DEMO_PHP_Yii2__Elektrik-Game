Elektrik Game
============================


![Elektrik Preview](https://repository-images.githubusercontent.com/107301853/549b9700-3dd6-11ea-986f-78dedc09b0a4)


Installation
------------

You need [Composer](https://getcomposer.org/download/) and SQLite to install

~~~
composer global require "fxp/composer-asset-plugin:^1.3.1"
composer install
~~~

Description
-------

It's a simple game. You have a field 5x5 round buttons. When you start new game random buttons are turned on. You should turn on all of them by clicking on them. When you click on button 9 neighbouring cells changes their state. The clicked button itself is always turned on after clicking.

- Main controller: `controllers/ElektrikController.php`
- Game logic: `processing/Elektrik.php`
- Database table model: `models/Leaderboard.php`
- Migrations to created database: `migrations`
- I use SQLite as database:
    - database data: `data/sqlite_data.db`
    - database config: `config/db.php`
