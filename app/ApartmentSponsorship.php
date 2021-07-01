<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentSponsorship extends Model
{
    protected $table="apartment_sponsorship";
    
    protected $fillable = [
        'apartment_id','sponsorship_id','user_id','amount','status','start_date','end_date'
    ];
}
