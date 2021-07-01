<?php

use Illuminate\Database\Seeder;
use App\Sponsorship; 

class SponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = config('sponsorships');

        foreach ($sponsorships as $sponsorship) {
            $newSponsorship = new Sponsorship();
            $newSponsorship->name = $sponsorship['name'];
            $newSponsorship->hours = $sponsorship['hours'];
            $newSponsorship->amount = $sponsorship['amount'];
            $newSponsorship->save();
            };
    }
}
