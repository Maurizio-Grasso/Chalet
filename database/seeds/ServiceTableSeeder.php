<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = config('additional_services');

        foreach ($services as $service) {
            $newService = new Service();
            $newService->service_name = $service['service_name'];
            $newService->service_info = $service['service_info'];
            $newService->service_icon = $service['service_icon'];
            $newService->save();
            };
    }
}
