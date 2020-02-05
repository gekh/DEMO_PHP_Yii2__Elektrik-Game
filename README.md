Elektrik Game
============================

It's a demonstration project to show my skills.

In this project I use a [PHP framework Yii2](https://www.yiiframework.com/), [jQuery](https://jquery.com/) and [SQLite](https://www.sqlite.org/index.html)


![Elektrik Preview](https://repository-images.githubusercontent.com/107301853/549b9700-3dd6-11ea-986f-78dedc09b0a4)


Installation
------------

You need [Composer](https://getcomposer.org/download/) and SQLite to be installed

~~~
composer global require "fxp/composer-asset-plugin:^1.3.1"
composer install
~~~

Nginx config:

~~~
server {
    listen                *:80;
    server_name           elektrik.dv;
    client_max_body_size  128m;
    root                  /var/www/elektrik/web;
    index                 index.php;
    
    access_log            /var/log/nginx/elektrik.access.log;
    error_log             /var/log/nginx/elektrik.error.log;
    
    location ~ /\. {
        root      /var/www/elektrik/web;
        autoindex off;
        deny      all;
    }
    location ~ \.php$ {
        root                 /var/www/elektrik/web;
        try_files            $uri =404;
        include              /etc/nginx/fastcgi_params;
        
        fastcgi_pass         127.0.0.1:9000;
        fastcgi_read_timeout 30000;
        fastcgi_param        SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    location ~ ^/assets/.*\.php$ {
        root      /var/www/elektrik/web;
        autoindex off;
        deny      all;
    }
    location / {
        root      /var/www/elektrik/web;
        try_files $uri $uri/ /index.php$is_args$args;
        autoindex off;
    }
    location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        root      /var/www/elektrik/web;
        try_files $uri =404;
        autoindex off;
    }
    
    sendfile off;
}
~~~

Description
-------

It's a simple game. You have a field 5x5 round buttons. When you start new game random buttons are turned on. You should turn on all of them by clicking on them. When you click on button 9 neighbouring cells changes their state. The clicked button itself is always turned on after clicking.

- Main controller: `controllers/ElektrikController.php`
- Game logic: `processing/Elektrik.php`
- Markup and JavaScript: `views/elektrik/elektrik.php`
- Database table model: `models/Leaderboard.php`
- Migrations to created database: `migrations`
- I use SQLite as database:
    - database data: `data/sqlite_data.db`
    - database config: `config/db.php`
