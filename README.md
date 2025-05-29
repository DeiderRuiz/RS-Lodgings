## 🏨 Hotel RS Lodgings
Aplicación web desarrollada con Laravel 10, Inertia.js y Vue.js, que permite a usuarios realizar reservas de habitaciones de hotel y a los administradores gestionar todo el sistema desde un panel completo. Incluye funcionalidades para pagos online, envío de correos, control de roles y más.

## ✨ Funcionalidades principales
- Navegación pública para usuarios no autenticados (clientes invitados).
- Sistema de autenticación y roles con Laravel Jetstream y Spatie Permission.
- Gestión completa de:
  - Reservas de habitaciones.
  - Habitaciones disponibles.
  - Servicios adicionales contratables por el cliente.
  - Ofertas y descuentos aplicables a reservas.
  - Sedes del hotel en otras ciudades.
- Comentarios y calificaciones de sedes por parte de usuarios autenticados.
- Pagos en línea integrados con PayPal SDK (modo Sandbox).
- Envío automático de correos electrónicos a los clientes con información de sus reservas (usando SMTP).
- Jobs en segundo plano para el envío de correos, optimizando la experiencia del usuario.

## 🧱 Tecnologías usadas
- Laravel 10 + Jetstream (Inertia stack)
- Vue.js 3
- Tailwind CSS
- Laravel Spatie Permission (control de roles)
- MySQL
- Inertia.js
- PayPal SDK (Sandbox)
- SMTP (para correos)
- Laravel Queue & Jobs
