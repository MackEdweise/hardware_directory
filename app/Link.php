<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "links";

    public function Device(){
        return $this->belongsTo('App\Device','device_id');
    }
}
?>