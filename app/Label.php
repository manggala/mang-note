<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    //
    protected $fillable = [
        'title', 'user_id',
    ];

    // One-to-many relationship
    public function notes(){
    	return $this->hasMany('App\Note');
    }

    // Many-to-one relationship
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
