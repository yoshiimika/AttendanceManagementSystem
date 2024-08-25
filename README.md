# 勤怠管理システム
勤怠管理システムを作成しました。  
ログイン後、各ボタンを押下する事で勤務開始/終了時間と休憩開始/終了時間を管理します。
　<img width="1512" alt="スクリーンショット 2024-08-22 7 13 23" src="https://github.com/user-attachments/assets/a82d7674-a192-4703-8170-81f5b8ea851c">

## 作成した目的
学習のアウトプットとして作成しました。

## URL
- 開発環境：http://localhost/
- phpMyAdmin:http://localhost:8080/

## 機能一覧
- 会員登録機能
- ログイン機能
- ログアウト機能
- 勤務開始/勤務終了(日を跨いだ時点で翌日の出勤操作に切り替え)
- 休憩開始/休憩終了(1日で何度も休憩が可能)
- 日付別勤怠情報取得
- ユーザー別勤怠情報取得
- ユーザー一覧情報取得
- ページネーション（５件ずつ取得）
- メール認証

## 使用技術（実行環境）
- laravel8.0
- laravel10.0
- MySQL8.0

## テーブル設計
<img width="646" alt="スクリーンショット 2024-08-22 7 29 07" src="https://github.com/user-attachments/assets/155e16c7-c01d-4b3f-b1f5-59c9b1a385dd">

## ER図
![Atte](https://github.com/user-attachments/assets/698274f4-d76c-4d95-9f57-f076a2803044)

# 開発環境
## Dockerビルド

1.ディレクトリの作成  
プロジェクトのディレクトリ構造を以下のように作成して下さい。
<pre>
AttendanceManagementSystem  
├── docker  
│   ├── mysql  
│   │   ├── data  
│   │   └── my.cnf  
│   ├── nginx  
│   │   └── default.conf  
│   └── php  
│       ├── Dockerfile  
│       └── php.ini  
├── docker-compose.yml  
└── src  
</pre>

2.docker-compose.ymlの作成  
`docker-compose.yml`ファイルに、以下の内容を追加して下さい。  
```
version: '3.8'

services:
    nginx:
        image: nginx:1.21.1
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./src:/var/www/
        depends_on:
            - php

    php:
        build: ./docker/php
        volumes:
            - ./src:/var/www/

    mysql:
        image: mysql:8.0.26
        environment:
            MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
            MYSQL_DATABASE: ${MYSQL_DATABASE}
            MYSQL_USER: ${MYSQL_USER}
            MYSQL_PASSWORD: ${MYSQL_PASSWORD}
        command:
            mysqld --default-authentication-plugin=mysql_native_password
        volumes:
            - ./docker/mysql/data:/var/lib/mysql
            - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
```

3.Nginxの設定  
`docker/nginx/default.conf`ファイルに以下の内容を追加して下さい。
```
server {
    listen 80;
    index index.php index.html;
    server_name localhost;

    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}
```

4.PHPの設定  
`docker/php/Dockerfile`ファイルに以下の内容を追加して下さい。
```
FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

WORKDIR /var/www
```
`docker/php/php.ini`ファイルに以下の内容を追加して下さい。
```
date.timezone = "Asia/Tokyo"

[mbstring]
mbstring.internal_encoding = "UTF-8"
mbstring.language = "Japanese"
```

5.MySQLの設定  
`docker/mysql/my.cnf`ファイルに以下の内容を追加して下さい。
```
[mysqld]
character-set-server = utf8mb4

collation-server = utf8mb4_unicode_ci

default-time-zone = 'Asia/Tokyo'
```

6.phpMyAdminの設定  
`docker-compose.yml`ファイルに、以下の内容を追加して下さい。  
```
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        environment:
            - PMA_ARBITRARY=1
            - PMA_HOST=mysql
            - PMA_USER=laravel_user
            - PMA_PASSWORD=laravel_pass
        depends_on:
            - mysql
        ports:
            - 8080:80
```

7.docker-compose up -d --build

## Laravel環境開発

1.docker-compose exec php bash

2.composer install

3..env.exampleファイルから.envを作成し、環境変数を変更

4.php artisan key:generate

5.php artisan migrate

6.php artisan db:seed

