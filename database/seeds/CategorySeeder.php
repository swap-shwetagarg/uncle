<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Truncate Records
        DB::table('categories')->truncate();

        // Insert Some Dummy Records
        DB::table('categories')->insert(array(
            array('service_type_id' => 1, 'category_name' => 'General Maintenance', 'status' => 1),
            array('service_type_id' => 2, 'category_name' => 'Diagnostics', 'status' => 1),
            array('service_type_id' => 2, 'category_name' => 'Inspections', 'status' => 1)
        ));
    }

}
