<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index(){
        //Obtiene todos los servicios y los agrupa por el campo "Tipo"
        $services = Service::all()->groupBy('tipo');
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Services/Index', ['services' => $services]),
            null => Inertia::render('Services/Index', ['services' => $services]),
            default => redirect()->route('index'),
        };
    }

    public function show(Service $service){
        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Services/Show', ['service'=>$service]),
            null => Inertia::render('Services/Show', ['service'=>$service]),
            default => redirect()->route('index'),
        };
    }
}
