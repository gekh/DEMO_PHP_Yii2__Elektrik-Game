Игра «Электрик»
============================


Установка
------------

Для установки потребуется Composer

~~~
php composer.phar global require "fxp/composer-asset-plugin:^1.3.1"
php composer.phar install
~~~

Описание
-------
- Ключевой контроллер: `controllers/ElektrikController.php`
- Вся игровая логика: `processing/Elektrik.php`
- Модель для таблицы из БД: `models/Leaderboard.php`
- Миграции для создания таблицы в БД: `migrations`
- Для БД используется SQLite:
    - данные: `data/sqlite_data.db`
    - конфиг БД: `config/db.php`
