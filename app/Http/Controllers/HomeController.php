<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Device;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $currentUser = Auth::user();
        $devices = Device::all();
        return view('home')->with([
            'currentUser' => $currentUser,
            'devices' => $devices
        ]);
    }
}
