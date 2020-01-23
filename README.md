Elektrik Game
============================


![Elektrik Preview](https://repository-images.githubusercontent.com/107301853/549b9700-3dd6-11ea-986f-78dedc09b0a4)


Установка
------------

Для установки потребуется [Composer](https://getcomposer.org/download/)

~~~
php composer.phar global require "fxp/composer-asset-plugin:^1.3.1"
php composer.phar install
~~~

Еще потребуется установить и включить SQLite, если он еще не установлен. Для Ubuntu это делается командой

~~~
sudo apt-get install php-sqlite3
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
