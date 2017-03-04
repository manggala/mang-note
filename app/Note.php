<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = [
        'title','content','deadline','is_done','is_alerted','label_id','user_id',
    ];


    // Many-to-one relationships
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function label(){
    	return $this->belongsTo('App\Label');
    }
}
