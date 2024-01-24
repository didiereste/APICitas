//-----------Configuración del Proyecto--------------//

Sigue estos pasos para configurar y ejecutar el proyecto:

1-Clona el repositorio: git clone https://github.com/didiereste/APICitas.git

2-Ingresar a la carpeta del proyecto Instala las dependencias: composer install

3-Configuración del archivo de entorno: cp .env.example .env

4-Genera la clave de la aplicación y realiza las migraciones: php artisan key:generate php artisan migrate --seed

5-Genera la clave secreta para JWT: php artisan jwt:secret

6-Inciar proyecto php artisan serve
