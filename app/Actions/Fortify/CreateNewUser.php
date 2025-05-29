<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'cedula' => ['required', 'numeric', 'digits_between:8,12'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'cellphone' => ['required', 'unique:users', 'string', 'numeric', 'digits:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'cedula' => $input['cedula'],
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'cellphone' => $input['cellphone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Asignar el rol con ID 3
        $role = Role::find(3); // Encuentra el rol por ID
        if ($role) {
            $user->assignRole($role->name); // Asigna el rol con Laravel Permission
        }
        return $user;
    }
}
