<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $roleAdmin = Role::create(['name'=>'administrador']);
        $roleEmpleado = Role::create(['name'=>'empleado']);
        $roleCliente = Role::create(['name'=>'cliente']);

        //Permisos
        Permission::create(['name'=>'ver:role'])->assignRole($roleAdmin);
        Permission::create(['name'=>'crear:role'])->assignRole($roleAdmin);
        Permission::create(['name'=>'editar:role'])->assignRole($roleAdmin);
        Permission::create(['name'=>'borrar:role'])->assignRole($roleAdmin);

        Permission::create(['name'=>'ver:permisos'])->assignRole($roleAdmin);

        Permission::create(['name'=>'ver:usuario'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'crear:usuario'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'editar:usuario'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'borrar:usuario'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);

        Permission::create(['name'=>'ver:pqrs'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'crear:pqrs'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'editar:pqrs'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'borrar:pqrs'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);

        Permission::create(['name'=>'ver:servicio'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'create:servicio'])->syncRoles([$roleAdmin, $roleEmpleado]);
        Permission::create(['name'=>'editar:servicio'])->syncRoles([$roleAdmin, $roleEmpleado]);
        Permission::create(['name'=>'borrar:servicio'])->syncRoles([$roleAdmin, $roleEmpleado]);

        Permission::create(['name'=>'ver:habitacion'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'crear:habitacion'])->syncRoles([$roleAdmin, $roleEmpleado]);
        Permission::create(['name'=>'editar:habitacion'])->syncRoles([$roleAdmin, $roleEmpleado]);
        Permission::create(['name'=>'borrar:habitacion'])->syncRoles([$roleAdmin, $roleEmpleado]);

        Permission::create(['name'=>'ver:pago'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'crear:pago'])->syncRoles([$roleAdmin, $roleEmpleado, $roleCliente]);
        Permission::create(['name'=>'editar:pago'])->syncRoles([$roleAdmin, $roleEmpleado]);

        $user = new User;
        $user->cedula='1110005566';
        $user->name='admin';
        $user->last_name='admin';
        $user->cellphone='1234567890';
        $user->email='admin@example.com';
        $user->password=bcrypt('admin123');
        $user->save();
        $user->assignRole($roleAdmin);

        $users = User::factory()->count(23)->create();

        // Asignar roles a los usuarios
        $users->take(3)->each(function ($user) use ($roleEmpleado) {
            $user->assignRole($roleEmpleado);
        });

        $users->skip(3)->each(function ($user) use ($roleCliente) {
            $user->assignRole($roleCliente);
        });

    }
}
