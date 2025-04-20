# Native Landing Page

Este proyecto es una landing page desarrollada utilizando **HTML**, **CSS** y **JavaScript**, haciendo uso de **Web Components** y una estructura **modular y compositiva**, similar a la que proporcionan los frameworks modernos.

Además, incluye un servidor backend básico implementado en **PHP**, que funciona como una **API REST** utilizando **PostgreSQL** como base de datos.

---

## 📦 Requisitos

- PHP (preferentemente versión 8.0 o superior)
- PostgreSQL y el controlador `pgsql` habilitado
- Node.js o cualquier gestor de paquetes (npm, bun, yarn, etc.)

---

## 🚀 Servidor

### Instalación

1. Descarga PHP desde:  
   [https://windows.php.net/downloads/releases/php-8.4.6-Win32-vs17-x64.zip](https://windows.php.net/downloads/releases/php-8.4.6-Win32-vs17-x64.zip)

2. Extrae el contenido del archivo ZIP en un directorio, por ejemplo:  
   `C:\Archivos de programa\PHP`

3. Agrega la ruta del directorio PHP a las **variables de entorno** para poder ejecutar el comando `php` desde la terminal.

4. Crea un archivo `php.ini` a partir del archivo `php.ini-development` incluido en la descarga.

5. En el archivo `php.ini`, descomenta (elimina el `;` al inicio) las siguientes líneas:

   ```ini
   extension_dir = "ext"
   extension=pdo_pgsql
   extension=pgsql

### Ejecución

Desde la raíz del proyecto, ejecuta el siguiente comando para iniciar el servidor:

`php -S localhost:3000 -t ./servidor`

## 💻 Cliente

### Instalación

Instala `live-server` de forma global con el siguiente comando:

`npm install -g live-server`

### Ejecución

Inicia el servidor del cliente con:

`live-server ./cliente --port=8000`

## 🧠 Notas

- Asegúrate de que PostgreSQL esté instalado y en funcionamiento si la API requiere conectarse a una base de datos.

- Este proyecto está enfocado en demostrar el uso de Web Components sin frameworks, ideal para aprender sobre arquitecturas modernas sin dependencias externas.