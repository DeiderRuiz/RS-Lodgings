<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $ciudades = Location::take(4)->get();
        return Inertia::render('CustomerDashboard', ['ciudades' => $ciudades]);
    }
}
