<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminServiceController extends Controller
{
    public function index(){
        $services = Service::all()->map(function($service) {
            $service->formatted_created_at = Carbon::parse($service->created_at)->format('m/d/Y h:i A');
            $service->formatted_updated_at = Carbon::parse($service->updated_at)->format('m/d/Y h:i A');
            return $service;
        });
        return Inertia::render('Admin/Services/Index', ['services' => $services]);
    }

    public function show(Service $service){
        $service->formatted_created_at = Carbon::parse($service->created_at)->format('d/m/Y h:i A');
        $service->formatted_updated_at = Carbon::parse($service->updated_at)->format('d/m/Y h:i A');
        return Inertia::render('Admin/Services/Show', ['service'=>$service]);
    }

    public function create(){
        return Inertia::render('Admin/Services/Create', ['service'=> new Service]);
    }

    public function store(Request $request){
        $request->validate([
            'nombre'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'tipo'=>['required', 'in:Actividades,Alimentacion,Alojamiento,Instalaciones,Servicios adicionales'],
            'para_habitacion'=>['required', 'boolean'],
            'detalles' => ['required', 'string', 'max:3000', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'precio'=>['required', 'numeric', 'digits_between:4,6'],
        ]);

        $service = new Service();
        $service->nombre = $request->nombre;
        $service->tipo = $request->tipo;
        $service->para_habitacion = $request->para_habitacion;
        $service->detalles = $request->detalles;
        $service->precio = $request->precio;
        $service->save();
        return redirect()->route('admin.services.show', ['service'=>$service->id])->with('message', "Has agregado el servicio {$service->nombre} exitosamente.");
    }

    public function edit(Service $service){
        return Inertia::render('Admin/Services/Edit', ['service' => $service]);
    }

    public function update(Request $request, Service $service){
        $request->validate([
            'nombre'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'tipo'=>['required', 'in:Actividades,Alimentacion,Alojamiento,Instalaciones,Servicios adicionales'],
            'para_habitacion'=>['required', 'boolean'],
            'detalles' => ['required', 'string', 'max:300', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'precio'=>['required', 'numeric', 'digits_between:4,6'],
        ]);

        $service->nombre = $request->nombre;
        $service->tipo = $request->tipo;
        $service->para_habitacion = $request->para_habitacion;
        $service->detalles = $request->detalles;
        $service->precio = $request->precio;
        $service->save();
        return redirect()->route('admin.services.show', ['service'=>$service->id])->with('message', "Has actualizado el servicio {$service->nombre} exitosamente.");
    }

    public function destroy(Service $service){
        $servicio = $service->nombre;
        $service->delete();
        return redirect()->route('admin.services.index')->with('message', "Has borrado el servicio {$servicio} exitosamente.");
    }
}
