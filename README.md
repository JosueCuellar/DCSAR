# Configuración del entorno de desarrollo para proyecto Laravel

Este documento describe los pasos para configurar un entorno de desarrollo para un proyecto Laravel en un servidor Windows Server 2022 de 64 bits (x86) con PHP 8.1.6 y XAMPP.

## Requisitos

- Microsoft Windows Server 2022 64 bits (x86)
- PHP: 8.1.6
- XAMPP: Debe ser una versión reciente que sea compatible con PHP 8.1.6.
- Laravel 9: Es el framework de desarrollo que se utilizará para el sistema.
- Composer: Es la herramienta de gestión de dependencias para PHP.
- SQLSERVER: Se utilizará para la gestión de la base de datos.
- GIT: Es la herramienta que se utilizará para clonar el proyecto.

## Instalación

1. Descarga e instala XAMPP, asegurándote de que sea una versión compatible con PHP 8.1.6.
2. Modifica el archivo php.ini para activar las extensiones necesarias.
3. Instala Laravel 9, que es el framework de desarrollo utilizado para el sistema.
4. Instala Composer, la herramienta de gestión de dependencias para PHP.
5. Descarga e instala los drivers SQL SERVER PHP y copia los archivos .dll en la carpeta xampp/php.
6. Instala GIT, la herramienta que se utilizará para clonar el proyecto.
7. Abre XAMPP Control Panel y asegúrate de que el servicio Apache esté corriendo.
8. Clona el proyecto Laravel en la carpeta xampp/htdocs/ utilizando el comando `git clone`.
9. Accede al directorio del proyecto clonado y ejecuta `composer install` para instalar las dependencias del proyecto.
10. Copia el archivo .env.example y renómbralo como .env, luego configura los valores de conexión a la base de datos en este archivo.
11. Genera una clave de aplicación única ejecutando `php artisan key:generate`.
12. Crea una base de datos con el nombre "dcsar" en SQLSERVER.
13. Ejecuta las migraciones de la base de datos con el comando `php artisan migrate`.
14. Navega a http://localhost/dcsar/public en tu navegador web para ver la aplicación funcionando.

## Uso

Para utilizar el sistema, simplemente navega a http://localhost/dcsar/public en tu navegador web.

## Contribuir

Si deseas contribuir al proyecto, por favor lee las directrices de contribución antes de enviar tus cambios.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.
