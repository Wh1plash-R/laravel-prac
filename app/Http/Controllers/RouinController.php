<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use Illuminate\Http\Request;

class RouinController extends Controller
{
    //
    public function welcome()
    {
        return view('welcome');
    }

    public function rouin()
    {
        $mentor = Learner::where('name', 'Rouin')->first();
        return view('rouin', [
            'mentor' => $mentor,
        ]);
    }
}
