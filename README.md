## Copiservi (Laravel)

Proyecto recreado desde un sitio antiguo de COPISERVI, manteniendo **branding/paleta** y un **panel** tipo “copias/bonos” como el original.

### Web pública
- **Inicio**: `/`
- **Servicios**: `/servicios`
- **Perfil**: `/perfil`
- **Contactar**: `/contactar`

### Panel
- **Login**: `/panel/login`
- **Dashboard**: `/panel`
- **Registro**: `/panel/registro`

### Bonos
En el sistema viejo se leían de ficheros `bono*.txt`. Aquí van por variables de entorno:
- `COPISERVI_BONO_1` (por defecto `400`)
- `COPISERVI_BONO_2`
- `COPISERVI_BONO_3`

### Desarrollo local (sin Docker)
Requisitos: PHP 8.3+, Composer, Node.

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run dev
php artisan serve
```

### Despliegue en Coolify (stack Nginx + PHP-FPM + MariaDB)
Configura las variables de entorno (DB y APP), ejecuta migraciones y seed:

```bash
php artisan migrate --force
php artisan db:seed --force
```

