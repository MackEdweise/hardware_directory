<?php
/**
 * Created by PhpStorm.
 * User: marcusedwards
 * Date: 2017-10-11
 * Time: 3:15 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "devices";

    public function Tags(){
        return $this->hasMany('App\Tag', 'device_id');
    }
    public function Links(){
        return $this->hasMany('App\Link', 'device_id');
    }
}