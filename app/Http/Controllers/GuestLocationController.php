<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Models\Location;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuestLocationController extends Controller
{
    public function show(Location $city){
        //Trae de la tabla galery todo lo que tiene relación con un elemento de x id de la tabla lacations
        $galeries=Galery::where('locations_id', $city->id)->get();
        //Trae de la tabla rating el promedio de calificación de un elemento de x id de la tabla lacations
        $ratings = round(Rating::where('locations_id', $city->id)->avg('calificacion'), 1);

        $fullRatings=Rating::where('locations_id', $city->id)->with('User')->orderBy('updated_at', 'desc')->get()->map(function($rating) {
            $rating->formatted_created_at = Carbon::parse($rating->created_at)->format('m/d/Y');
            $rating->formatted_updated_at = Carbon::parse($rating->updated_at)->format('m/d/Y');
            $rating->descuento = round($rating->descuento * 100);
            return $rating;
        });

        return Inertia::render('Locations/Show', ['city'=>$city, 'galeries'=>$galeries, 'ratings'=>$ratings, 'fullRatings'=>$fullRatings]);
    }
}
