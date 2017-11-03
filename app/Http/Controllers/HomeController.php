<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Device;
use App\Tag;

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
        $devices = Device::with('Tags')->get();
        $tags = Tag::all();

        $uniqueTags = [];

        foreach($tags as $tag){
            if(!array_key_exists($tag->name,$uniqueTags)){
                $uniqueTags[$tag->name] = $tag;
            }
        }

        return view('home')->with([
            'currentUser' => $currentUser,
            'devices' => $devices,
            'tags' => collect($uniqueTags)
        ]);
    }
}
