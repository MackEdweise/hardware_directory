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
            $devices = Device::all();
            return Redirect::route('home')->withErrors($validator)->withInput()->with([
                'currentUser' => $currentUser,
                'devices' => $devices
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

        if(!is_null($request->file('device-image'))){

            $image = $request->file('device-image');
            $mime = '.'.$image->getClientOriginalExtension();
            $imageName = $currentUser->id.'-avatar'.$mime;

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

        $device->save();

        $currentUser = Auth::user();
        $devices = Device::all();
        return view('home')->with([
            'currentUser' => $currentUser,
            'devices' => $devices
        ]);
    }
}