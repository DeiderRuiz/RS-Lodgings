<?php

use App\Http\Controllers\AdminDealController;
use App\Http\Controllers\AdminLocationController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DealRoomController;
use App\Http\Controllers\DealServiceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\GuestLocationController;
use App\Http\Controllers\GuestReservationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

Route::get('PoliticaDePrivacidad', fn() => Inertia::render('PrivacyPolicy'))->name('Privacidad');
Route::get('TerminosDeServicios', fn() => Inertia::render('TermsOfService'))->name('Terminos');

//Inicio (LocationController muestra algunas ubicaciones en el inicio)
Route::get('/', [LocationController::class,'welcome'])->name('index');

//Errores
Route::get('/error', function () {
    return Inertia::render('Errors', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('error');

//Habitaciones
Route::get('habitaciones', [RoomController::class, 'index'])->name('guest.rooms.index');
Route::get('habitaciones/{room}', [RoomController::class, 'show'])->name('guest.rooms.show');
//Ofertas
Route::get('ofertas', [DealController::class, 'index'])->name('guest.deals.index');
Route::get('oferta/{deal}', [DealController::class, 'show'])->name('guest.deals.show');
//Reservas
Route::get('reservar/{room}', [ReservationController::class,'create'])->name('guest.reservations.create');
Route::post('reservar/{room}', [GuestReservationController::class, 'store'])->name('guest.reservations.store');
Route::get('reserva/{reserva}', [GuestReservationController::class, 'show'])->name('guest.reservations.show');
Route::get('reservar/{reserva}/edit', [ReservationController::class,'edit'])->name('guest.reservations.edit');
Route::patch('reservar/{reserva}/{room}', [GuestReservationController::class,'update'])->name('guest.reservations.update');
Route::patch('cancelar/{reserva}', [GuestReservationController::class, 'cancel'])->name('guest.reservations.cancel');
//Servicios
Route::get('servicios', [ServiceController::class, 'index'])->name('guest.services.index');
Route::get('servicios/{service}', [ServiceController::class, 'show'])->name('guest.services.show');
//Pagos
Route::post('pago-de-reserva/{reserva}', [PaymentController::class, 'RealizarPago'])->name('payments');
//Ubicaciones
Route::get('ubicaciones', [LocationController::class, 'index'])->name('guest.locations.index');
Route::get('ubicaciones/{city}', [GuestLocationController::class, 'show'])->name('guest.locations.show');

//PARA LAS RUTAS QUE SE ENCUENTRAN TRAS EL LOGIN
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    /* Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); */

    //RUTAS DEL CLIENTE
    Route::middleware(['auth', 'AccessByRole:3'])->group(function () {
        
        Route::get('/customer-dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

        //Calificaciones
        Route::post('calificar/{location}', [RatingController::class, 'rate'])->name('customer.ratings.rate');
        
        //Habitaciones
        Route::get('c/habitaciones', [RoomController::class, 'index'])->name('customer.rooms.index');
        Route::get('c/habitaciones/{room}', [RoomController::class, 'show'])->name('customer.rooms.show');
        
        //Ofertas
        Route::get('c/ofertas', [DealController::class, 'index'])->name('customer.deals.index');
        Route::get('c/oferta/{deal}', [DealController::class, 'show'])->name('customer.deals.show');

        //Perfil
        Route::get('c/perfil', [CustomerProfileController::class, 'show'])->name('customer.profile.show');
        
        //Reservas
        Route::get('c/reservas', [ReservationController::class,'index'])->name('customer.reservations.index');
        Route::get('c/reservar/{room}', [ReservationController::class,'create'])->name('customer.reservations.create');
        Route::post('c/reservar/{room}', [ReservationController::class, 'store'])->name('customer.reservations.store');
        Route::get('c/reserva/{reserva}', [ReservationController::class, 'show'])->name('customer.reservations.show');
        Route::get('c/reservar/{reserva}/edit', [ReservationController::class,'edit'])->name('customer.reservations.edit');
        Route::patch('c/reservar/{reserva}/{room}', [ReservationController::class,'update'])->name('customer.reservations.update');
        Route::patch('c/cancelar/{reserva}', [ReservationController::class, 'cancel'])->name('customer.reservations.cancel');
        
        //Servicios
        Route::get('c/servicios', [ServiceController::class, 'index'])->name('customer.services.index');
        Route::get('c/servicios/{service}', [ServiceController::class, 'show'])->name('customer.services.show');
        
        //Ubicaciones
        Route::get('c/ubicaciones', [LocationController::class, 'index'])->name('customer.locations.index');
        Route::get('c/ubicaciones/{city}', [LocationController::class, 'show'])->name('customer.locations.show');
    });
    
    //RUTAS DEL ADMIN Y EL EMPLEADO
    Route::middleware(['AccessByRole:1,2'])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('admin.dashboard');

        //Clientes
        Route::get('admin/clientes', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('admin/clientes/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        
        //Habitaciones
        Route::get('admin/habitaciones', [AdminRoomController::class, 'index'])->name('admin.rooms.index');
        Route::get('admin/habitaciones/{room}', [AdminRoomController::class, 'show'])->name('admin.rooms.show');
        
        //Habitaciones y Servicios
        Route::get('admin/habitacion-y-servicios/{room}', [RoomServiceController::class, 'show'])->name('rooms.services.show');
        Route::post('habitacion/{room}/-y-servicio/{service}', [RoomServiceController::class, 'attach'])->name('rooms.services.attach');
        Route::post('habitacion/{room}/-sin-servicio/{service}', [RoomServiceController::class, 'detach'])->name('rooms.services.detach');
        Route::get('admin/servicio-y-habitaciones/{service}', [ServiceRoomController::class, 'show'])->name('services.rooms.show');
        Route::post('servicio/{service}/-y-habitacion/{room}', [ServiceRoomController::class, 'attach'])->name('services.rooms.attach');
        Route::post('servicio/{service}/-sin-habitacion/{room}', [ServiceRoomController::class, 'detach'])->name('services.rooms.detach');
        
        //Ofertas
        Route::get('admin/ofertas', [AdminDealController::class, 'index'])->name('admin.deals.index');
        Route::get('admin/ofertas/{deal}', [AdminDealController::class, 'show'])->name('admin.deals.show');
        Route::get('admin/nueva-oferta', [AdminDealController::class, 'create'])->name('admin.deals.create');
        Route::post('nueva-oferta', [AdminDealController::class, 'store'])->name('admin.deals.store');
        Route::get('admin/actualizar-oferta/{deal}', [AdminDealController::class, 'edit'])->name('admin.deals.edit');
        Route::patch('actualizar-oferta/{deal}', [AdminDealController::class, 'update'])->name('admin.deals.update');
        Route::delete('borrar-oferta/{deal}', [AdminDealController::class, 'destroy'])->name('admin.deals.destroy');
        
        //Ofertas y Habitaciones
        Route::get('admin/oferta-y-habitaciones/{deal}', [DealRoomController::class, 'show'])->name('deal.rooms.show');
        Route::post('oferta/{deal}/-y-habitacion/{room}', [DealRoomController::class, 'attach'])->name('deal.rooms.attach');
        Route::post('oferta/{deal}/sin-habitacion/{room}', [DealRoomController::class, 'detach'])->name('deal.rooms.detach');
        
        //Ofertas y Servicios
        Route::get('admin/oferta-y-servicios/{deal}', [DealServiceController::class, 'show'])->name('deal.services.show');
        Route::post('oferta/{deal}/-y-servicio/{service}', [DealServiceController::class, 'attach'])->name('deal.services.attach');
        Route::post('oferta/{deal}/sin-servicio/{service}', [DealServiceController::class, 'detach'])->name('deal.services.detach');
        
        //Reservas
        Route::get('admin/reservas', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
        Route::get('admin/reserva/{reserva}', [AdminReservationController::class, 'show'])->name('admin.reservations.show');
        
        //Servicios
        Route::get('admin/servicios', [AdminServiceController::class, 'index'])->name('admin.services.index');
        Route::get('admin/servicios/{service}', [AdminServiceController::class, 'show'])->name('admin.services.show');
        
        //Ubicaciones
        Route::get('admin/ubicaciones', [AdminLocationController::class, 'index'])->name('admin.locations.index');
        Route::get('admin/ubicaciones/{location}', [AdminLocationController::class, 'show'])->name('admin.locations.show');
    });

    //Rol Administrador
    Route::middleware(['AccessByRole:1'])->group(function () {
        //Empleados
        Route::get('admin/empleados', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('admin/empleados/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/admin/register-employee', [EmployeeController::class, 'create'])->name('register.employee.create');
        Route::post('/admin/register-employee', [EmployeeController::class, 'store'])->name('register.employee.store');

        //Galería
        Route::get('admin/galeria/{location}', [GaleryController::class, 'index'])->name('galeries.index');
        Route::post('galeria/{location}', [GaleryController::class, 'store'])->name('galeries.store');
        Route::delete('galeria/{galery}', [GaleryController::class, 'destroy'])->name('galeries.destroy');

        //Habitaciones
        Route::get('admin/crear-habitacion', [AdminRoomController::class, 'create'])->name('admin.rooms.create');
        Route::post('crear-habitacion', [AdminRoomController::class, 'store'])->name('admin.rooms.store');
        Route::get('admin/actualizar-habitacion/{room}', [AdminRoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::patch('actualizar-habitacion/{room}', [AdminRoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('borrar-habitacion/{room}', [AdminRoomController::class, 'destroy'])->name('admin.rooms.destroy');

        //Ubicaciones
        Route::get('admin/nueva-ubicacion', [AdminLocationController::class, 'create'])->name('admin.locations.create');
        Route::post('nueva-ubicacion', [AdminLocationController::class, 'store'])->name('admin.locations.store');
        Route::get('admin/actualizar-ubicacion/{location}', [AdminLocationController::class, 'edit'])->name('admin.locations.edit');
        Route::patch('actualizar-ubicacion/{location}', [AdminLocationController::class, 'update'])->name('admin.locations.update');
        Route::delete('borrar-ubicacion/{location}', [AdminLocationController::class, 'destroy'])->name('admin.locations.destroy');

        //Servicios
        Route::get('admin/crear-servicios', [AdminServiceController::class, 'create'])->name('admin.services.create');
        Route::post('crear-servicio', [AdminServiceController::class, 'store'])->name('admin.services.store');
        Route::get('admin/actualizar-servicio/{service}', [AdminServiceController::class, 'edit'])->name('admin.services.edit');
        Route::patch('actualizar-servicio/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('borrar-servicio/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
    });
});
