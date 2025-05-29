<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DealController extends Controller
{
    //Obtener todas las ofertas de la db
    public function index(){
        $deals=Deal::select(
            'id', 'tipo_de_oferta', 'descripcion', 'descuento', 
            'fecha_de_inicio', 'fecha_de_fin', 'noches_minimas', 'vista'
        )->get();

        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Deals/Index', ['deals'=>$deals]),
            null => Inertia::render('Deals/Index', ['deals'=>$deals]),
            default => redirect()->route('index'),
        };
    }

    public function show(Deal $deal){
        $deal->fecha_inicio = Carbon::parse($deal->fecha_de_inicio)->translatedFormat('d \d\e F \d\e\l Y');
        $deal->fecha_fin = Carbon::parse($deal->fecha_de_fin)->translatedFormat('d \d\e F \d\e\l Y');
        $deal->descuento = round($deal->descuento * 100);

        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Deals/Show', ['deal'=>$deal->load(['rooms','services'])]),
            null => Inertia::render('Deals/Show', ['deal'=>$deal->load(['rooms','services'])]),
            default => redirect()->route('index'),
        };
    }
}
