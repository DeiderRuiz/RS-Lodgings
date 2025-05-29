<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{
    public function index(){
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'cliente'); // o el nombre real del rol
        })->get()->map(function($employee) {
            $employee->formatted_created_at = $employee->created_at->format('m/d/Y h:i A');
            $employee->formatted_updated_at = $employee->updated_at->format('m/d/Y h:i A');
            return $employee;
        });
        return Inertia::render('Admin/Customers/Index', ['customers'=>$customers]);
    }

    public function show($idCustomer){

        $customer = User::where('id', $idCustomer)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'cliente');
            })->firstOrFail();

        $customer->formatted_created_at = $customer->created_at->format('m/d/Y h:i A');
        $customer->formatted_updated_at = $customer->updated_at->format('m/d/Y h:i A');

        return Inertia::render('Admin/Customers/Show', ['customer'=>$customer]);
    }
}
