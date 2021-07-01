<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'apartment_id','img_path','img_description','is_cover'
    ];

    public function apartment(){
        return $this -> belongsTo('App\Apartment');
    }
}
