<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function index() 
    {
        $users = User::all();

        return view('welcome', compact('users'));
    }

    public function store(Request $request) 
    {
        return $request->all();
    }
}
