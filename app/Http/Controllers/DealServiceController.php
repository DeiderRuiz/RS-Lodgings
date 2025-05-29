<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealServiceController extends Controller
{
    public function show(Deal $deal){
        $services = Service::get();
        $attached_services = $deal->services->pluck('id')->ToArray();
        return Inertia::render('Admin/DealService/Show', [
            'deal' => $deal,
            'services' => $services,
            'attached_services' => $attached_services,
        ]);
    }

    public function attach(Deal $deal, $service){
        $deal->services()->attach($service);
        return redirect()->back()->with('message', 'Has agregado un servicio a esta oferta');
    }

    public function detach(Deal $deal, $service){
        $deal->services()->detach($service);
        return redirect()->back()->with('message', 'Has removido un servicio de esta oferta');
    }
}
