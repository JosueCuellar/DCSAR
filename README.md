Instalar Xammp, composer y Node

Clonar el repositorio

------------------------------------------------------------------------------------------------

Dentro de la carpeta del proyeccto en una terminal:

composer global require laravel/installer

composer install

cp .env.example .env

    nombre de la base: sgi
    
    usuario de la base: root
    
    sin contrasena
    
php artisan key:generate

composer require mike42/escpos-php

composer require spatie/laravel-permission

composer require tightenco/ziggy

php artisan config:cache

------------------------------------------------------------------------------------------------

hacer php artisan migrate

Luego desde phpMyAdmin immportar los datos del archivo sql sggi.sql

Al entrar al sistema, se pedira crear un usuario, este sera el usuario administrador
