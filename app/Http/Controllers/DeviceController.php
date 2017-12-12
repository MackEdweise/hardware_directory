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
use App\Tag;
use App\Link;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SSH;
use Storage;

class DeviceController
{
    public function add(Request $request){

        $rules = array(
            'device-name' => 'required',
            'device-description' => 'required'
        );

        $messages = [
            'device-name.required' => 'Device name is required. Save not successful.',
            'device-description.required' => 'Device description is required. Save not successful.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $currentUser = Auth::user();

        if ($validator->fails()) {
            if($currentUser->admin){
                $devices = Device::with('Tags')->get();
            }
            else{
                $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
            }
            $tags = Tag::all();

            $uniqueTags = [];

            foreach($tags as $tag){
                if(!array_key_exists($tag->name,$uniqueTags)){
                    $uniqueTags[$tag->name] = $tag;
                }
            }
            return Redirect::route('home')->withErrors($validator)->withInput()->with([
                'currentUser' => $currentUser,
                'devices' => $devices,
                'tags' => $uniqueTags
            ]);
        }

        $device = new Device();

        $device->name = $request->input('device-name');
        $device->description = $request->input('device-description');

        if(!is_null($request->input('device-connectivity'))){
            $device->connectivity = $request->input('device-connectivity');
        }
        if(!is_null($request->input('device-low'))){
            $device->low_voltage = $request->input('device-low');
        }
        if(!is_null($request->input('device-high'))){
            $device->high_voltage = $request->input('device-high');
        }
        if(!is_null($request->input('device-speed'))){
            $device->speed = $request->input('device-speed');
        }
        if(!is_null($request->input('device-manufacturers'))){
            $device->manufacturers = $request->input('device-manufacturers');
        }
        if(!is_null($request->input('device-platform'))){
            $device->platform = $request->input('device-platform');
        }
        if(!is_null($request->input('device-datasheet'))){
            $device->datasheet = $request->input('device-datasheet');
        }
        if(!is_null($request->input('device-category'))){
            $device->category = $request->input('device-category');
        }
        if(!is_null($request->input('device-available'))){
            $device->available = $request->input('device-available');
        }

        $device->save();

        if(!is_null($request->file('device-image'))){

            $image = $request->file('device-image');
            $mime = '.'.$image->getClientOriginalExtension();
            $imageName = $device->id.'-avatar'.$mime;

            SSH::into('Blue')->put($image->getRealPath(), '/home/nginx/html/HardwareDirectory/'.$imageName);

            $device->image = $imageName;

            Storage::disk('public')->delete($imageName);
        }

        if(!is_null($request->input('tags'))) {

            foreach ($request->input('tags') as $tag) {
                $new = new Tag();
                $new->device_id = $device->id;
                $new->name = $tag;
                $new->created_at = date('Y-m-d H:i:s');
                $new->updated_at = date('Y-m-d H:i:s');
                $new->save();
            }
        }

        if(!is_null($request->input('links'))) {

            foreach ($request->input('links') as $link) {
                $new = new Link();
                $new->device_id = $device->id;
                $new->address = $link;
                $new->created_at = date('Y-m-d H:i:s');
                $new->updated_at = date('Y-m-d H:i:s');
                $new->save();
            }
        }

        $device->user_id = $currentUser->id;
        $device->approved = false;

        $device->save();

        if($currentUser->admin){
            $devices = Device::with('Tags')->get();
        }
        else{
            $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
        }
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
            'tags' => $uniqueTags
        ]);
    }
    public function edit(Request $request){

        $rules = array(
            '_device_id' => 'required',
        );

        $messages = [
            '_device_id.required' => 'Device edit was unsuccessful due to an error.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $currentUser = Auth::user();

        if ($validator->fails()) {
            if($currentUser->admin){
                $devices = Device::with('Tags')->get();
            }
            else{
                $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
            }
            $tags = Tag::all();

            $uniqueTags = [];

            foreach($tags as $tag){
                if(!array_key_exists($tag->name,$uniqueTags)){
                    $uniqueTags[$tag->name] = $tag;
                }
            }
            return Redirect::route('home')->withErrors($validator)->withInput()->with([
                'currentUser' => $currentUser,
                'devices' => $devices,
                'tags' => $uniqueTags
            ]);
        }

        $device = Device::where('id', '=', $request->input('_device_id'))->first();

        $device->name = $request->input('device-name-'.$device->id);
        $device->description = $request->input('device-description-'.$device->id);

        if(!is_null($request->input('device-connectivity-'.$device->id))){
            $device->connectivity = $request->input('device-connectivity-'.$device->id);
        }
        if(!is_null($request->input('device-low-'.$device->id))){
            $device->low_voltage = $request->input('device-low-'.$device->id);
        }
        if(!is_null($request->input('device-high-'.$device->id))){
            $device->high_voltage = $request->input('device-high-'.$device->id);
        }
        if(!is_null($request->input('device-speed-'.$device->id))){
            $device->speed = $request->input('device-speed-'.$device->id);
        }
        if(!is_null($request->input('device-manufacturers-'.$device->id))){
            $device->manufacturers = $request->input('device-manufacturers-'.$device->id);
        }
        if(!is_null($request->input('device-platform-'.$device->id))){
            $device->platform = $request->input('device-platform-'.$device->id);
        }
        if(!is_null($request->input('device-datasheet-'.$device->id))){
            $device->datasheet = $request->input('device-datasheet-'.$device->id);
        }
        if(!is_null($request->input('device-category-'.$device->id))){
            $device->category = $request->input('device-category-'.$device->id);
        }
        if(!is_null($request->input('device-available-'.$device->id))){
            $device->available = $request->input('device-available-'.$device->id);
        }

        $device->save();

        if(!is_null($request->file('device-image-'.$device->id))){

            $image = $request->file('device-image-'.$device->id);
            $mime = '.'.$image->getClientOriginalExtension();
            $imageName = $device->id.'-avatar'.$mime;

            SSH::into('Blue')->put($image->getRealPath(), '/home/nginx/html/HardwareDirectory/'.$imageName);

            $device->image = $imageName;

            Storage::disk('public')->delete($imageName);
        }

        $oldTags = Tag::where('device_id', '=', $request->input('_device_id'));
        $oldTags->delete();

        if(!is_null($request->input('tags-'.$device->id))) {

            foreach ($request->input('tags-'.$device->id) as $tag) {
                $new = new Tag();
                $new->device_id = $device->id;
                $new->name = $tag;
                $new->created_at = date('Y-m-d H:i:s');
                $new->updated_at = date('Y-m-d H:i:s');
                $new->save();
            }
        }

        $oldLinks = Link::where('device_id', '=', $request->input('_device_id'));
        $oldLinks->delete();

        if(!is_null($request->input('links-'.$device->id))) {

            foreach ($request->input('links-'.$device->id) as $link) {
                $new = new Link();
                $new->device_id = $device->id;
                $new->address = $link;
                $new->created_at = date('Y-m-d H:i:s');
                $new->updated_at = date('Y-m-d H:i:s');
                $new->save();
            }
        }

        $device->save();

        $currentUser = Auth::user();
        if($currentUser->admin){
            $devices = Device::with('Tags')->get();
        }
        else{
            $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
        }
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
            'tags' => $uniqueTags
        ]);
    }
    public function approve(Request $request)
    {

        $rules = array(
            '_device_id' => 'required',
        );

        $messages = [
            '_device_id.required' => 'Device approval was unsuccessful due to an error.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $currentUser = Auth::user();

        if ($validator->fails()) {
            if($currentUser->admin){
                $devices = Device::with('Tags')->get();
            }
            else{
                $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
            }
            $tags = Tag::all();

            $uniqueTags = [];

            foreach($tags as $tag){
                if(!array_key_exists($tag->name,$uniqueTags)){
                    $uniqueTags[$tag->name] = $tag;
                }
            }
            return Redirect::route('home')->withErrors($validator)->withInput()->with([
                'currentUser' => $currentUser,
                'devices' => $devices,
                'tags' => $uniqueTags
            ]);
        }

        $device = Device::where('id','=',$request->input('_device_id'))->first();
        if($device->approved != true){
            $device->approved = true;
        }
        else{
            $device->approved = false;
        }

        $device->save();

        if($currentUser->admin){
            $devices = Device::with('Tags')->get();
        }
        else{
            $devices = Device::with('Tags')->where('approved','=',true)->orWhere('user_id','=',$currentUser->id)->get();
        }
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
            'tags' => $uniqueTags
        ]);

    }
}