<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rate(Request $request, Location $location){
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        /* $isAuth = $user && $user->roles->first()->id === 3; */

        Rating::updateOrCreate(
            [
                'locations_id' => $location->id,
                'users_id' => $user->id,
            ],
            [
                'calificacion' => $request->calificacion,
                'review' => $request->review,
            ]
        );

        return redirect()->back()->with('message', "Gracias por brindarnos tu opinión.");
    }
}
