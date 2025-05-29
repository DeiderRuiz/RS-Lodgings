<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminDealController extends Controller
{
    public function index(){
        $deals=Deal::all()->map(function($deal) {
            $deal->formatted_created_at = Carbon::parse($deal->created_at)->format('m/d/Y h:i A');
            $deal->formatted_updated_at = Carbon::parse($deal->updated_at)->format('m/d/Y h:i A');
            $deal->descuento = round($deal->descuento * 100);
            return $deal;
        });
        return Inertia::render('Admin/Deals/Index', ['deals'=>$deals]);
    }

    public function show(Deal $deal){
        $deal->formatted_created_at = Carbon::parse($deal->created_at)->format('m/d/Y h:i A');
        $deal->formatted_updated_at = Carbon::parse($deal->updated_at)->format('m/d/Y h:i A');
        $deal->fecha_inicio = Carbon::parse($deal->fecha_de_inicio)->format('m/d/Y');
        $deal->fecha_fin = Carbon::parse($deal->fecha_de_fin)->format('m/d/Y');
        $deal->descuento = round($deal->descuento * 100);
        return Inertia::render('Admin/Deals/Show', ['deal'=>$deal]);
    }

    public function create(){
        return Inertia::render('Admin/Deals/Create', ['deal' => new Deal]);
    }

    public function store(Request $request){
        $request->validate([
            'nombre'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'tipo_de_oferta'=>['required', 'in:Temporada,Duración,Especial'],
            'descripcion'=>['required', 'string', 'max:3000', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'descuento'=>['required', 'integer', 'min:1', 'max:100'],
            'fecha_de_inicio'=>['required', 'date', 'after_or_equal:today'],
            'fecha_de_fin'=>['required', 'date', 'after_or_equal:fecha_de_inicio'],
            'noches_minimas'=>['required', 'integer', 'min:1'],
            'vista'=>['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $descuento = $request->descuento/100;
        $path = $request->file('vista')->store('files', 'public');

        $deal = new Deal();
        $deal->nombre = $request->nombre;
        $deal->tipo_de_oferta = $request->tipo_de_oferta;
        $deal->descripcion = $request->descripcion;
        $deal->descuento = $descuento;
        $deal->fecha_de_inicio = $request->fecha_de_inicio;
        $deal->fecha_de_fin = $request->fecha_de_fin;
        $deal->noches_minimas = $request->noches_minimas;
        $deal->vista = Storage::url($path);
        $deal->save();
        return redirect()->route('admin.deals.show', ['deal'=>$deal->id])->with('message', "Has agregado la oferta {$deal->nombre} exitosamente.");;
    }

    public function edit(Deal $deal){
        return Inertia::render('Admin/Deals/Edit', ['deal' => $deal]);
    }

    public function update(Request $request, Deal $deal){
        $request->validate([
            'nombre'=>['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'tipo_de_oferta'=>['required', 'in:Temporada,Duración,Especial'],
            'descripcion'=>['required', 'string', 'max:300', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,: ]*$/'],
            'descuento'=>['required', 'integer', 'min:1', 'max:100'],
            'fecha_de_inicio'=>['required', 'date', 'after_or_equal:today'],
            'fecha_de_fin'=>['required', 'date', 'after_or_equal:fecha_de_inicio'],
            'noches_minimas'=>['required', 'integer', 'min:1'],
            'vista'=>['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $descuento = $request->descuento/100;
        
        $deal->nombre = $request->nombre;
        $deal->tipo_de_oferta = $request->tipo_de_oferta;
        $deal->descripcion = $request->descripcion;
        $deal->descuento = $descuento;
        $deal->fecha_de_inicio = $request->fecha_de_inicio;
        $deal->fecha_de_fin = $request->fecha_de_fin;
        $deal->noches_minimas = $request->noches_minimas;
        if ($request->hasFile('vista')) {
            $path = $request->file('vista')->store('files', 'public');
            $deal->vista = Storage::url($path);
        };
        $deal->save();
        return redirect()->route('admin.deals.show', ['deal'=>$deal->id])->with('message', "Has actualizado la oferta {$deal->nombre} exitosamente.");
    }

    public function destroy(Deal $deal){
        $oferta = $deal->nombre;
        $deal->delete();
        return redirect()->back()->with('message', "Has borrado la oferta {$oferta} exitosamente.");
    }
}
