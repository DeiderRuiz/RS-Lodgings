<?php

namespace App\Http\Controllers;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Routing\Controller;

class CustomerProfileController extends UserProfileController
{
    public function show(Request $request)
    {
        $this->validateTwoFactorAuthenticationState($request);

        // Verifica el rol del usuario
        $view = $request->user()->hasRole('cliente') 
            ? 'Profile/CustomerShow' 
            : 'Profile/Show';

        return Inertia::render($view, [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all(),
        ]);
    
    }
}
