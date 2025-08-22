
# 🍽️ Cafetería UPDS

**Sistema de Pedidos Digitales para Cafetería Universitaria**

Una plataforma web que optimiza la experiencia de pedidos en la cafetería universitaria, reduciendo filas y tiempos de espera mientras mejora la gestión de inventario y la satisfacción estudiantil.

## 📋 Tabla de Contenidos

- [Visión del Proyecto](#-visión-del-proyecto)
- [Características Principales](#-características-principales)
- [Tecnologías](#-tecnologías)
- [Instalación](#-instalación)
- [Uso](#-uso)
- [Arquitectura](#-arquitectura)
- [Equipo de Desarrollo](#-equipo-de-desarrollo)
- [Metodología](#-metodología)
- [Contribuciones](#-contribuciones)
- [Licencia](#-licencia)

## 🎯 Visión del Proyecto

**Transformar la experiencia gastronómica universitaria** mediante una plataforma digital que permite a los estudiantes:
- Visualizar el menú en tiempo real
- Realizar pedidos anticipados
- Evitar filas y optimizar su tiempo
- Recibir notificaciones de estado de pedido

## ✨ Características Principales

### Para Estudiantes
- 📱 **Catálogo Digital**: Visualización del menú diario con disponibilidad en tiempo real
- 🛒 **Sistema de Pedidos**: Creación intuitiva de pedidos personalizados
- ⏰ **Programación de Pedidos**: Posibilidad de programar pedidos hasta 2 horas en adelante
- 💳 **Pagos Seguros**: Procesamiento de pagos con QR y confirmación inmediata
- 📊 **Seguimiento en Tiempo Real**: Monitoreo del estado del pedido (recibido, preparando, listo)
- 🔔 **Notificaciones**: Alertas cuando el pedido está listo para recoger

### Para Personal de Cafetería
- 🏠 **Dashboard de Cocina**: Vista organizada de pedidos pendientes por prioridad
- 📈 **Gestión de Inventario**: Control de disponibilidad de productos en tiempo real
- 📊 **Analytics**: Estadísticas de productos más populares y tiempos de preparación
- ⚡ **Optimización de Flujo**: Herramientas para reducir tiempos de espera

## 🛠️ Tecnologías

### Backend
- **PHP 8.1+** con **Laravel Framework**
- **MySQL** para base de datos
- **Laragon** como entorno de desarrollo

### Frontend
- **Blade Templates** (Laravel)
- **Tailwind CSS** para estilos
- **JavaScript** para interactividad

### Herramientas de Desarrollo
- **Git** para control de versiones
- **Laragon** para desarrollo local
- **Laravel Migrations** para estructura de BD
- **Laravel Seeders** para datos de prueba

## 🚀 Instalación

### Prerequisitos
- PHP 8.1 o superior
- Composer
- Laragon (recomendado) o XAMPP/WAMP
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tu-usuario/cafeteria-connect.git
cd cafeteria-connect
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
```
Editar `.env` con tus configuraciones de base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafeteria_upds
DB_USERNAME=root
DB_PASSWORD=
```

4. **Generar clave de aplicación**
```bash
php artisan key:generate
```

5. **Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
```

6. **Compilar assets**
```bash
npm run dev
```

7. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 📖 Uso

### Usuarios de Prueba

#### Administrador
- **Email**: admin@cafeteriaupds.com
- **Password**: admin2024
- **Nombre**: Roberto Jiménez

#### Personal de Cocina
- **Email**: cocina@cafeteriaupds.com
- **Password**: cocina2024
- **Nombre**: María Elena Condori

#### Estudiantes
- **Email**: luciana@upds.edu.bo
- **Password**: student2024
- **Nombre**: Luciana Zapana Quispe (Scrum Master)

- **Email**: camila@upds.edu.bo
- **Password**: student2024
- **Nombre**: Camila Torres (Persona Primaria)

### Flujo Principal

1. **Registro/Login** → El estudiante se registra o inicia sesión
2. **Explorar Menú** → Navega por las opciones disponibles
3. **Crear Pedido** → Agrega productos al carrito
4. **Programar/Pagar** → Selecciona hora de entrega y paga
5. **Seguimiento** → Monitorea el estado en tiempo real
6. **Recoger** → Recibe notificación cuando está listo

## 🏗️ Arquitectura

### Modelo MVC de Laravel
```
app/
├── Http/Controllers/
│   ├── MenuController.php
│   ├── OrderController.php
│   ├── Kitchen/KitchenController.php
│   └── Admin/DashboardController.php
├── Models/
│   ├── User.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── MenuItem.php
└── ...

resources/views/
├── layouts/app.blade.php
├── menu/
├── kitchen/
└── admin/
```

### Base de Datos
- **users**: Información de usuarios y roles
- **menu_items**: Productos disponibles
- **orders**: Pedidos realizados
- **order_items**: Detalles de cada pedido
- **categories**: Categorías de productos

## 👥 Equipo de Desarrollo

### Roles Scrum

**Product Owner**
- Rosalia Lopez Montalvo - Docente Universitario

**Scrum Master**
- Noelia Luciana Zapana Quispe - Est. Ing. Sistemas

### Development Team

**Frontend Developer**
- Camila Belén Quispe Aliaga - Est. Ing. Sistemas, Especialista en UI/UX
- Noelia Luciana Zapana Quispe - Est. Ing. Sistemas, Especialista en UI/UX

**Backend Developers**
- Josué Escobar Rios - Est. Ing. Sistemas, Arquitectura y APIs
- Aarón - Est. Ing. Sistemas, Backend y DevOps

**UX/UI Designer & Tester**
- Carlos Daza Guarachi - Est. Ing. Sistemas, Diseño y Testing

**Database Administrator**
- Daher Quinteros Arevalo - Est. Ing. Sistemas, Modelado y Optimización

## 📊 Metodología

### Scrum Framework
- **Sprints**: 4 semanas
- **Daily Stand-ups**: Comunicación diaria del progreso
- **Sprint Planning**: Planificación detallada de historias de usuario
- **Sprint Review**: Demostración de funcionalidades completadas
- **Sprint Retrospective**: Mejora continua del proceso

### Definition of Done
- ✅ Código revisado por pares
- ✅ Pruebas unitarias implementadas
- ✅ Funcionalidad probada en diferentes navegadores
- ✅ Documentación actualizada
- ✅ Aprobación del Product Owner

### Convenciones de Código
- Seguir PSR-12 para PHP
- Usar nombres descriptivos para variables y funciones
- Comentar código complejo
- Mantener métodos pequeños y focalizados

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 📞 Contacto

**Universidad Privada Domingo Savio**
- Proyecto académico - Ingeniería de Sistemas

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
