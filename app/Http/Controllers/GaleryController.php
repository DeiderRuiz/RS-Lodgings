<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GaleryController extends Controller
{
    public function index(Location $location){
        $galeries = Galery::where('locations_id', $location->id)->get();
        return Inertia::render('Admin/Galeries/Index', ['galeries' => $galeries, 'location' => $location]);
    }

    public function store(Request $request, Location $location){
        $request->validate([
            'imagen.*'=>['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagenes = $request->file('imagen');
        $cantidad = count($imagenes);

        foreach ($imagenes as $imagen) {
            $path = $imagen->store('files', 'public');
            $galery = new Galery();
            $galery->locations_id = $location->id;
            $galery->imagen = Storage::url($path);
            $galery->save();
        }

        return redirect()->back()->with('message', "Has agregado {$cantidad} imagen(es) a la galería exitosamente.");
    }

    public function destroy(Galery $galery){
        $galery->delete();
        return redirect()->back()->with('message', "Has removido una imagen de la galería exitosamente.");
    }
}
