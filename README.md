# Portal Web Empresa Astilleros del Caribe
## laravel10_asticar_inertia

## Descripción de la Configuración del Proyecto para desplegar sobre Docker-Compose:

### Requisitos:
1-Docker
2-Docker-Compose

### Servicios:
1-PHP 8.1
2-Nginx 1.19.4
3-Mysql 5.4
4-PhpMyadmin

### Pasos a seguir:

1- Clonar el repositorio con el comando: git clone https://github.com/eddyjj92/laravel10_asticar_inertia.git  
2- Configurar variables de entorno: cambiar extensión del archivo .env.example a .env, ya todas las variables vienen 
configuradas por defecto, opcionalmente puede cambiar lo q considere necesario.
3- Instalar Dependencias con el comando: composer install
4- Contruir las imagenes con el comando: docker-compose build
5- Crear los contenedores a partir de las imágenes descargadas con el comando: docker-compose up -d
6- Entrar como usuario root al contenedor principal para dar permisos a la aplicación de laravel a contruir la caché con los comandos: docker-compose exec -u root app bash y chmod -R 777 * , estos permisos se ponen inicialmente para q la aplicación pueda escribir en los directorios de caché, pero no es recomendable dar permisos abiertos a todos los grupos, por lo que debe restringir los permisos que considere necesarios.
6- Entrar con el cliente phpmyadmin e importar la base de datos que se encuentra en el directorio principal de la aplicación, con el nombre astica.sql.
7- La aplicación se encuentra lista, corre por defecto en el puerto 80.

Cualquier duda consultarme a través del móvil 52121494.
Muchas Gracias.
