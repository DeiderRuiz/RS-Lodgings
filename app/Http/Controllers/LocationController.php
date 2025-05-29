<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Models\Location;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LocationController extends Controller
{
    //Obtener todas las ubicaciones de la DB (Para la vista de inicio y locations)
    public function welcome(){
        $ciudades=Location::take(4)->get();
        return Inertia::render('Welcome', ['ciudades'=>$ciudades]);
    }

    public function index(){

        $citiesWithoutRating = Location::get();
        // Obtener los promedios de las calificaciones en una sola consulta con groupBy
        $ratings = Rating::selectRaw('locations_id, AVG(calificacion) as avg_rating')
            ->groupBy('locations_id')->pluck('avg_rating', 'locations_id');

        // Mapear los promedios a cada ciudad
        $cities = $citiesWithoutRating->map(function ($city) use ($ratings) {
            // Verifica si existe un rating para esta ciudad, si no, asigna un 0 o nulo
            $city->rating = isset($ratings[$city->id]) ? round($ratings[$city->id], 1) : null;
            return $city;
        });

        $user = auth()->user();
        $role = $user?->roles->first()->id ?? null;

        return match ($role) {
            3 => Inertia::render('Customers/Locations/Index', ['cities'=>$cities]),
            null => Inertia::render('Locations/Index', ['cities'=>$cities]),
            default => redirect()->route('index'),
        };
    }

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

        $user = auth()->user();

        $fullRatings = Rating::where('locations_id', $city->id)
            ->when($user, function ($query) use ($user) {
                // Excluir la calificación del usuario autenticado si existe
                return $query->where('users_id', '!=', $user->id);
            })->with('User')->orderBy('updated_at', 'desc')->get()
            ->map(function($rating) {
                $rating->formatted_created_at = Carbon::parse($rating->created_at)->format('m/d/Y');
                $rating->formatted_updated_at = Carbon::parse($rating->updated_at)->format('m/d/Y');
                $rating->descuento = round($rating->descuento * 100);
                return $rating;
            });

        if ($user) {
            $myRating=Rating::with('User')->where('locations_id', $city->id)->where('users_id', $user->id)->first();
            if ($myRating) {
                $myRating->formatted_created_at = Carbon::parse($myRating->created_at)->format('m/d/Y');
                $myRating->formatted_updated_at = Carbon::parse($myRating->updated_at)->format('m/d/Y');
            }
        }

        return Inertia::render('Customers/Locations/Show', ['city'=>$city, 'galeries'=>$galeries, 'ratings'=>$ratings, 'fullRatings'=>$fullRatings, 'myRating'=>$myRating]);
    }
}
