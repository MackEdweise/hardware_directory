<?php
/**
 * Created by PhpStorm.
 * User: marcusedwards
 * Date: 2017-10-25
 * Time: 8:06 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Device;

class DeviceController
{
    public function add(){
        $currentUser = Auth::user();
        $devices = Device::all();
        return view('home')->with([
            'currentUser' => $currentUser,
            'devices' => $devices
        ]);
    }
}