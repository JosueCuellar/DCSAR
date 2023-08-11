Instalar Xammp PHP 8.1.6, composer, Laravel 9

Clonar el repositorio

------------------------------------------------------------------------------------------------

Dentro de la carpeta del proyecto en una terminal:

composer global require laravel/installer

composer install

cp .env.example .env

    Nombre de la base: dcsar
    
php artisan key:generate
------------------------------------------------------------------------------------------------

Realizar un  php artisan migrate

