<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $user = new User();

        $user->name = 'Francisca';
        $user->email = 'franiwiwi@hotmail.com';

        return response()->json([$user],200);
    }

    //
}
