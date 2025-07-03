# 📦 L’Air Pur - E-commerce de Perfumes

Este repositorio contiene el código fuente del proyecto **L’Air Pur**, un sistema web de comercio electrónico para la venta de perfumes, desarrollado con **CodeIgniter 4, PHP 8.2 y MySQL**, bajo arquitectura MVC.



---

## 🚀 Características principales
- Registro y autenticación de usuarios
- Catálogo con filtros dinámicos
- Carrito de compras con AJAX
- Facturación automática
- Panel administrativo para gestión de productos, usuarios y reportes
- Cumple normas RGPD y buenas prácticas de seguridad

---

## ⚙️ Tecnologías utilizadas
- **Backend:** PHP 8.2, CodeIgniter 4
- **Frontend:** Bootstrap 5, JavaScript ES6, AJAX/Fetch
- **Base de datos:** MySQL (MariaDB en XAMPP)
- **Servidor:** Apache 2.4
- **Dependencias:** Composer

---

## 📂 Requisitos previos
- **PHP ≥ 8.2**
- **Composer**
- **MySQL ≥ 8**
- **Apache ≥ 2.4**
- Extensiones habilitadas: `intl`, `mbstring`, `mysqli`, `openssl`, `json`, `curl`

---

# 🖥️ Instalación en Windows (XAMPP)

1️⃣ **Clona el repositorio**
```bash
git clone https://github.com/tu-usuario/tu-repo.git
cd tu-repo
2️⃣ Ubica el proyecto en tu carpeta htdocs

Ejemplo:

bash
Copiar
Editar
C:\xampp\htdocs\lairpur
3️⃣ Configura la base de datos

Abre phpMyAdmin.

Crea una base de datos llamada lairpur.

Importa el archivo lairpur.sql incluido en la carpeta /database.

4️⃣ Configura el entorno

Renombra el archivo .env.example a .env.

Abre el archivo .env y coloca tus datos de conexión:

dotenv
Copiar
Editar
database.default.hostname = localhost
database.default.database = lairpur
database.default.username = root
database.default.password = 
app.baseURL = 'http://localhost/lairpur/public/'
5️⃣ Instala dependencias con Composer

bash
Copiar
Editar
composer install
6️⃣ Habilita las reglas de reescritura en Apache

Asegúrate de que el módulo mod_rewrite esté activado.

Abre el archivo httpd.conf y busca esta línea:

apache
Copiar
Editar
#LoadModule rewrite_module modules/mod_rewrite.so
Descoméntala (elimina el # al inicio).

7️⃣ Reinicia Apache y accede al proyecto

Abre tu navegador y entra a:

arduino
Copiar
Editar
http://localhost/lairpur/public
🐧 Instalación en Linux (LAMP)
1️⃣ Clona el repositorio en /var/www

bash
Copiar
Editar
sudo git clone https://github.com/tu-usuario/tu-repo.git /var/www/lairpur
cd /var/www/lairpur
2️⃣ Configura permisos

bash
Copiar
Editar
sudo chown -R www-data:www-data /var/www/lairpur
sudo chmod -R 755 /var/www/lairpur/writable
3️⃣ Crea la base de datos

bash
Copiar
Editar
mysql -u root -p
Dentro del cliente de MySQL:

sql
Copiar
Editar
CREATE DATABASE lairpur;
exit;
Importa el archivo SQL:

bash
Copiar
Editar
mysql -u root -p lairpur < database/lairpur.sql
4️⃣ Configura el archivo .env

bash
Copiar
Editar
cp .env.example .env
nano .env
Edita los valores de conexión a la base de datos según tu entorno.

5️⃣ Instala dependencias con Composer

bash
Copiar
Editar
composer install
6️⃣ Configura Apache

Crea un archivo de configuración en /etc/apache2/sites-available/lairpur.conf con el siguiente contenido:

apache
Copiar
Editar
<VirtualHost *:80>
    ServerName lairpur.local
    DocumentRoot /var/www/lairpur/public
    <Directory /var/www/lairpur/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
Luego:

bash
Copiar
Editar
sudo a2ensite lairpur.conf
echo "127.0.0.1 lairpur.local" | sudo tee -a /etc/hosts
7️⃣ Reinicia Apache y accede al proyecto

bash
Copiar
Editar
sudo systemctl restart apache2
En tu navegador:

arduino
Copiar
Editar
http://lairpur.local
---

## 📩 Contacto

¿Tienes preguntas, sugerencias o te gustaría contribuir al proyecto?

No dudes en ponerte en contacto:

- 📧 **Email:** [quintanafabiangustavo@gmail.com](mailto:quintanafabiangustavo@gmail.com)
- 💼 **LinkedIn:** (https://www.linkedin.com/in/fabian-quintana-60a59a325)(https://www.linkedin.com/in/fabian-quintana-60a59a325))
- 🐙 **GitHub:** [@FabianGQuintana]https://github.com/FabianGQuintana
---

¡Gracias por visitar **L’Air Pur**! ✨

