<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class HabitacionesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function muestra_rooms_a_cliente_con_rol_3()
    {
        
        Role::create(['id' => 1, 'name' => 'administrador']);
        Role::create(['id' => 2, 'name' => 'empleado']);
        Role::create(['id' => 3, 'name' => 'cliente']);

        // Crear usuario con ese rol
        $user = User::factory()->create();
        $user->roles()->attach(3);

        // Crear habitaciones
        $room = Room::factory()->create();

        // Autenticar usuario
        $this->actingAs($user);

        // Llamar a la ruta
        $response = $this->get(route('customer.rooms.index'));

        // Verificar vista y datos
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Customers/Rooms/Index')
                 ->has('rooms', 1)
                 ->where('rooms.0.id', $room->id)
        );
    }

    /** @test */
    public function muestra_rooms_a_invitado_sin_autenticar()
    {
        $room = Room::factory()->create();

        $response = $this->get(route('guest.rooms.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Rooms/Index')
                 ->has('rooms', 1)
        );
    }

    /** @test */
    public function redirige_a_index_si_el_rol_no_es_3()
    {
        $role = Role::create(['id' => 2, 'name' => 'admin']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user);

        $response = $this->get(route('guest.rooms.index'));

        $response->assertRedirect(route('index'));
    }
}
