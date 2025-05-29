<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminLocationController extends Controller
{
    public function index(){
        $locations=Location::all()->map(function($location) {
            $location->formatted_created_at = Carbon::parse($location->created_at)->format('m/d/Y h:i A');
            $location->formatted_updated_at = Carbon::parse($location->updated_at)->format('m/d/Y h:i A');
            return $location;
        });
        return Inertia::Render('Admin/Locations/Index', ['locations'=>$locations]);
    }

    public function show(Location $location){
        $location->formatted_created_at = Carbon::parse($location->created_at)->format('m/d/Y h:i A');
        $location->formatted_updated_at = Carbon::parse($location->updated_at)->format('m/d/Y h:i A');
        return Inertia::render('Admin/Locations/Show', ['location'=>$location]);
    }

    public function create(){
        return Inertia::render('Admin/Locations/Create', ['location' => new Location]);
    }

    public function store(Request $request){
        $request->validate([
            'ciudad'=>['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]*$/'],
            'direccion'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ#-°,. ]*$/'],
            'url'=>['required', 'url', 'max:255'],
            'cellphone_hotel'=>['required', 'numeric', 'digits:10'],
            'descripcion'=>['required', 'string', 'max:3000', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'portada'=>['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'imagen.*'=>['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $path = $request->file('portada')->store('files', 'public');

        $location = new Location();
        $location->ciudad = $request->ciudad;
        $location->direccion = $request->direccion;
        $location->url = $request->url;
        $location->cellphone_hotel = $request->cellphone_hotel;
        $location->descripcion = $request->descripcion;
        $location->portada = Storage::url($path);
        $location->save();

        foreach ($request->file('imagen') as $imagen) {
            $path = $imagen->store('files', 'public');
            $galery = new Galery();
            $galery->locations_id = $location->id;
            $galery->imagen = Storage::url($path);
            $galery->save();
        }

        return redirect()->route('admin.locations.index')->with('message', "Has agregado el hotel de {$location->ciudad} ({$location->direccion}) exitosamente.");
    }

    public function edit(Location $location){
        return Inertia::render('Admin/Locations/Edit', ['location' => $location]);
    }

    public function update(Request $request, Location $location){
        $request->validate([
            'ciudad'=>['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]*$/'],
            'direccion'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ#-°,. ]*$/'],
            'url'=>['required', 'url', 'max:255'],
            'cellphone_hotel'=>['required', 'numeric', 'digits:10'],
            'descripcion'=>['required', 'string', 'max:300', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'portada'=>['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('portada')) {
            $path = $request->file('portada')->store('files', 'public');
            $urlPortada = Storage::url($path);
        } else {
            $urlPortada = $location->portada; // Mantiene la imagen existente si no se sube una nueva.
        }
        

        $location->update([
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            'url' => $request->url,
            'cellphone_hotel' => $request->cellphone_hotel,
            'descripcion' => $request->descripcion,
            'portada' => $urlPortada,
        ]);
        
        return redirect()->route('admin.locations.show', ['location'=>$location->id])->with('message', "Has actualizado el hotel de {$location->ciudad} ({$location->direccion}) exitosamente.");
    }

    public function destroy(Location $location){
        $ciudad = $location->ciudad;
        $direccion = $location->direccion;
        $location->delete();
        return redirect()->route('admin.locations.index')->with('message', "Has borrado el hotel de {$ciudad} ({$direccion}) exitosamente.");
    }
}
