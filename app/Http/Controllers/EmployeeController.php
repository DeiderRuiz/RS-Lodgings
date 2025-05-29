<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmployeeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index(){
        $employees = User::whereHas('roles', function($query) {
            $query->where('name', 'empleado'); // o el nombre real del rol
        })->get()->map(function($employee) {
            $employee->formatted_created_at = $employee->created_at->format('m/d/Y h:i A');
            $employee->formatted_updated_at = $employee->updated_at->format('m/d/Y h:i A');
            return $employee;
        });
        return Inertia::render('Admin/Employees/Index', ['employees'=>$employees]);
    }

    public function show($idEmployee){
        $employee = User::where('id', $idEmployee)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'empleado');
            })->firstOrFail();

        $employee->formatted_created_at = $employee->created_at->format('m/d/Y h:i A');
        $employee->formatted_updated_at = $employee->updated_at->format('m/d/Y h:i A');

        return Inertia::render('Admin/Employees/Show', ['employee'=>$employee]);
    }

    public function create(){
        $user = Auth::user();
        if ($user && $user->roles->first()->id === 1) {
            return Inertia::render('Auth/RegisterEmployee');
        }
        return redirect()->route('index');
    }

    public function store(Request $request){
        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:8,12'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'cellphone' => ['required', 'unique:users', 'string', 'numeric', 'digits:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        $user = User::create([
            'cedula' => $request->cedula,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'password' => Hash::make($request->cedula),
        ]);

        $role = Role::find(2); // Encuentra el rol por ID
        if ($role) {
            $user->assignRole($role->name); // Asigna el rol con Laravel Permission
        }

        $destinatario = $request->input('email'); // Correo del empleado

        try {
            Mail::to($destinatario)->send(new RegisterEmployeeMail($user));
            Log::info('Correo enviado a ' . $destinatario);
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
        }
        
        return redirect()->route('employees.show', ['employee'=>$user])->with('message', "Has registrado el empleado {$user->name} {$user->last_name} exitosamente.");
    }
}
