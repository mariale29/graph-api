# Graph API - Laravel

 Gestión de nodos 

## Requisitos Previos

Antes de comenzar, asegúrate de cumplir con lo siguiente:

* **PHP >= 8.1**
* **Composer** instalado.
* **Extensión Intl:** Debe estar activa en tu `php.ini`.
> **Tip para XAMPP:** Abre el Panel de Control, ve a `Config -> PHP (php.ini)`, busca `;extension=intl` y quita el punto y coma (`;`) del principio. Reinicia Apache.


##  Instalación y Configuración

Sigue estos pasos para poner en marcha el proyecto localmente:

1. **Clonar el proyecto y entrar al directorio:**
bash
cd mi-proyecto




2. **Instalar dependencias:**

composer install




3. **Configurar el entorno:**
Copia el archivo de ejemplo y configura tus credenciales de base de datos en el nuevo `.env`:

cp .env.example .env

4. **Preparar la Base de Datos:**
El proyecto utiliza SQLite, por lo que no necesitas configurar un servidor de base de datos

Ejecuta las migraciones y carga los datos de prueba (seeds):

php artisan migrate --seed



5. **Documentación con Swagger:**
Si el paquete no está instalado, agrégalo y genera los archivos:

composer require "darkaonline/l5-swagger"
php artisan l5-swagger:generate


## Ejecución

Para iniciar el servidor de desarrollo, ejecuta:


php artisan serve

La API estará disponible en `http://localhost:8000`

##  Documentación de la API (Swagger)

Una vez que el servidor esté corriendo, puedes interactuar con los endpoints y ver los esquemas de datos desde la interfaz de Swagger:

🔗 **URL:** http://localhost:8000/api/documentation

### Comandos útiles de Swagger

* **Generar cambios:** Si modificas los comentarios en los controladores, ejecuta:

php artisan l5-swagger:generate





