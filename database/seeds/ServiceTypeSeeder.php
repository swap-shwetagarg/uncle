<?php

use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Truncate Records
        DB::table('services_type')->truncate();

        // Insert Some Dummy Records
        DB::table('services_type')->insert(array(
            array('service_type' => 'Repair & Maintenance Services', 'status' => 1),
            array('service_type' => 'Diagnostics & Inspections', 'status' => 1)
        ));
    }

}
