<?php
/**
 * Created by PhpStorm.
 * User: marcusedwards
 * Date: 2017-11-03
 * Time: 10:02 AM
 */
namespace App\Http\Controllers;

use App\Device;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {

        $devices = Device::all();
        return view('home')->with([
            'currentUser' => null,
            'devices' => $devices
        ]);
    }
}