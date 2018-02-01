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
use File;
use Response;

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
        if(!is_null($request->input('device-code-field'))){
            $device->code = $request->input('device-code-field');
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
        if(!is_null($request->input('device-code-'.$device->id.'-field'))){
            $device->code = $request->input('device-code-'.$device->id.'-field');
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
    public function downloadSampleCSV(){

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        $filename = "sample_data.csv";

        return Response::download($filename, $filename, $headers);
    }
    public function uploadCSV(Request $request){

        $rules = array(
            'data-file' => 'required'
        );

        $messages = [
            'data-file.required' => 'Please select a file to upload.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::route('home')->withErrors($validator);
        }

        $file = fopen($request->file('data-file')->getRealPath(), "r");

        if($file) {

            $countDevices = 0;

            $row = 0;
            while ( ($data = fgetcsv($file)) !== false) {

                if($row != 0) {

                    // get device info
                    if(!empty($data[0]) && !is_null($data[0])){

                        $name = $data[0];
                        $platforms = !empty($data[1]) ? $data[1] : null;
                        $category = !empty($data[2]) ? $data[2] : null;
                        $datasheet = !empty($data[3]) ? $data[3] : null;
                        $description = !empty($data[4]) ? $data[4] : null;
                        $connectivity = !empty($data[5]) ? $data[5] : null;
                        $lowVoltage = !empty($data[6]) ? $data[6] : null;
                        $highVoltage = !empty($data[7]) ? $data[7] : null;
                        $speed = !empty($data[8]) ? $data[8] : null;
                        $manufacturers = !empty($data[9]) ? $data[9] : null;

                        $existing = Device::where('name', '=', $name)->first();

                        if(!is_null($existing)){
                            $device = $existing;
                        }
                        else{
                            $device = new Device();
                        }

                        $device->name = $name;
                        $device->description = $description;
                        $device->connectivity = $connectivity;
                        $device->platform = $platforms;
                        $device->category = $category;
                        $device->datasheet = $datasheet;
                        $device->low_voltage = $lowVoltage;
                        $device->high_voltage = $highVoltage;
                        $device->speed = $speed;
                        $device->manufacturers = $manufacturers;

                        $device->save();

                        $countDevices += 1;
                    }
                }

                $row += 1;
            }

            fclose($file);
            File::delete($file);

            return Redirect::route('home')->with('alert-success', 'Successfully created '.$countDevices.' devices!');

        }
        else{
            return Redirect::route('home')->with('alert-danger', 'No data file was found.');
        }
    }
}