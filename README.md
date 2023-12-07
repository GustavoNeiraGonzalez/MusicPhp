# Proyecto app musica php laravel 
Esta aplicación, desarrollada en Laravel (PHP), ofrece una plataforma basada en API para disfrutar, almacenar y explorar canciones de manera personalizada.


# que se necesita para iniciar la app? 
PHP 8.2.6
MySQL\MySQL Server 8.0
Laravel Framework 10.13.5
# caracteristicas
- Autenticación 
-Almacenamiento de Canciones
-Contador de Visitas (con contralador de visitas por usuario (tiempo minimo))
-Gestión de Artistas
-Exploración por Género
-Roles de Usuario y Permisos
-API para Interactuar

# Dependencias
-        "php": "^8.1",
-        "guzzlehttp/guzzle": "^7.2",
-        "laravel/framework": "^10.10",
-        "laravel/sanctum": "^3.2",
-        "laravel/tinker": "^2.8",
-        "spatie/laravel-permission": "^5.10",
-        "tymon/jwt-auth": "^2.0"
    
-    "require-dev"
-        "fakerphp/faker": "^1.9.1",
-        "laravel/pint": "^1.0",
-        "laravel/sail": "^1.18",
-        "mockery/mockery": "^1.4.4",
-        "nunomaduro/collision": "^7.0",
-        "phpunit/phpunit": "^10.1",
-        "spatie/laravel-ignition": "^2.0"

# Instrucciones:
 tener composer instalado y ejecutar composer install
 dentro de la carpeta backend. Ejecutar proyecto -php artisan serve
# imagenes
1) registro usuario
<img width="367" alt="register" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/139873d7-7ac3-420d-9f7b-936e048a6c9b">

2) Login
<img width="360" alt="login token" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/56815d7d-0412-4cb1-b4a3-d56fe24aab6a">

3) eliminacion cuenta (autenticado como admin)
<img width="365" alt="delete with admin login" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/50c714e5-e6a5-47b3-85e9-a4f458e0c8cb">

4) Subida de cancion
<img width="342" alt="post song succesfully" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/40e4bf9b-46ac-43a5-8118-455f7f8d36f3">

5) ejemplo error subida de cancion: cancion duplicada
 <img width="557" alt="error post duplicate songs" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/0ccfe488-931c-4841-ba33-cc99b8776963">

6) ejemplo error No autenticado:
<img width="513" alt="error post song without login" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/8ecf58f2-d22c-42a2-9683-8fc91abf16b8">

7) obtener lista canciones: 
<img width="382" alt="get songs" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/bc0c4186-24e5-43db-8832-f1b90fff4321">

8) ver visitas de una cancion:
<img width="309" alt="get visits songs id" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/c69d057e-aa05-422d-9b35-dfe856af7ad5">

9) unir una cancion a un artista:
<img width="552" alt="unida con exito artista cancion" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/84bf3dc5-6db8-4c83-b5b3-339faf181bbe">

10) borrada la union de cancion con artista
<img width="559" alt="borrada la union de cancion y artista" src="https://github.com/GustavoNeiraGonzalez/MusicPhp/assets/71986954/3e9a08e7-1fc9-4b0f-a56c-902e5748aae1">


--etc...
