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
    - конфиг БД: `config/test.php`

Тестирование
-------

Тесты находятся в папке `tests`
 
Тесты можно запустить коммандой
```
codecept run
```

или

```
vendor/bin/codecept run
``` 


The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Запуск acceptance-тестов

1. Установите PhantomJS:

```
brew install phantomjs
```

2. Запустит PhantomJS:
```
phantomjs --webdriver=4444 --cookies-file=/Users/h/dev/phantomjs_cookie.txt 
```

3. Запустите тесты:
```
codecept run
```
