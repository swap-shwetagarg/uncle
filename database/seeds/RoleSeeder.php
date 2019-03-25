<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //delete users table records
        DB::table('roles')->delete();
        //insert some dummy records
        DB::table('roles')->insert(array(
            array('name' => 'User', 'display_name' => 'User Mode', 'description' => 'User Mode'),
            array('name' => 'Admin', 'display_name' => 'Admin Mode', 'description' => 'Admin Mode'),
            array('name' => 'Mechanic', 'display_name' => 'Mechanic Mode', 'description' => 'Mechanic Mode'),
        ));
    }

}
