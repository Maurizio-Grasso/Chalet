<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'email_sender','message_text','date'
    ];

    public function apartment(){
        return $this -> belongsTo('App\Apartment');
    }

}
