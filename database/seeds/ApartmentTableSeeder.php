<?php

use Illuminate\Database\Seeder;
use App\Apartment;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments=config('apartments');
        
        foreach($apartments as $apartment){ 
            $newApartment = new Apartment();
            $newApartment-> title = $apartment['title'];
            $newApartment-> address = $apartment['address'];
            $newApartment-> user_id = $apartment['user_id'];
            $newApartment-> rooms_n = $apartment['rooms_n'];
            $newApartment-> beds_n = $apartment['beds_n'];
            $newApartment-> bathroom_n = $apartment['bathroom_n'];
            $newApartment-> dimensions = $apartment['dimensions'];
            $newApartment-> latitude = $apartment['latitude'];
            $newApartment-> longitude = $apartment['longitude'];
            $newApartment-> description = $apartment['description'];
            $newApartment-> visible = $apartment['visible'];
            $newApartment-> price_per_night = $apartment['price_per_night'];
            $newApartment-> rating = $apartment['rating'];
            $newApartment->save();
        };
    }
}
