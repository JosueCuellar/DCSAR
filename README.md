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

## Descargas

- XAMPP: https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.1.6/xampp-windows-x64-8.1.6-0-VS16-installer.exe/download
- Composer: https://getcomposer.org/Composer-Setup.exe
- Drivers de SQL Server para PHP: https://go.microsoft.com/fwlink/?linkid=2226724

## Instalación

1. Descarga e instala XAMPP desde el enlace proporcionado en la sección "Descargas".
2. Descarga e instala Composer desde el enlace proporcionado en la sección "Descargas".
3. Abre el Panel de Control de Windows y busca "Editar las variables de entorno del sistema".
4. En la ventana "Propiedades del sistema", haz clic en "Variables de entorno".
5. En la sección "Variables del sistema", busca la variable "Path" y haz clic en "Editar".
6. Haz clic en "Nuevo" y agrega la ruta a la carpeta donde se encuentra el ejecutable php.exe (por ejemplo, C:\xampp\php).
7. Haz clic en "Aceptar" para guardar los cambios y cerrar todas las ventanas.
8. Reinicia cualquier ventana de línea de comandos abierta para que los cambios surtan efecto.
9. Instala Laravel 9, que es el framework de desarrollo utilizado para el sistema.
10. Descarga e instala los drivers SQL SERVER PHP desde el enlace proporcionado en la sección "Descargas" y copia los archivos .dll en la carpeta xampp/php.
11. Instala GIT, la herramienta que se utilizará para clonar el proyecto.
12. Abre XAMPP Control Panel y asegúrate de que el servicio Apache esté corriendo.
13. Clona el proyecto Laravel en la carpeta xampp/htdocs/ utilizando el comando `git clone`.
14. Accede al directorio del proyecto clonado y ejecuta `composer install` para instalar las dependencias del proyecto.
15. Copia el archivo .env.example y renómbralo como .env, luego configura los valores de conexión a la base de datos en este archivo.
16. Genera una clave de aplicación única ejecutando `php artisan key:generate`.
17. Crea una base de datos con el nombre "dcsar" en SQLSERVER.
18. Ejecuta las migraciones de la base de datos con el comando `php artisan migrate:refresh --seed`.
y acceder al sistema con el rol de administrador, para agregar usuarios con roles y probar la aplicación
   Correo electrónico : admin@admin.com   Contrasena : password
19. Navega a http://localhost/dcsar/public en tu navegador web para ver la aplicación funcionando.

## Uso

Para utilizar el sistema, simplemente navega a http://localhost/dcsar/public en tu navegador web.

## Contribuir

Si deseas contribuir al proyecto, por favor lee las directrices de contribución antes de enviar tus cambios.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.
