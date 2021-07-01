<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            ApartmentTableSeeder::class,
            MessagesTableSeeder::class,
            ServiceTableSeeder::class,
            SponsorshipTableSeeder::class,
            ViewsTableSeeder::class,
            ImagesTableSeeder::class,

        ]);
    }
}