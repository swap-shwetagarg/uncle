<?php

use Illuminate\Database\Seeder;

class PassportClientSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //delete users table records
        DB::table('oauth_clients')->delete();
        //insert some dummy records
        DB::table('oauth_clients')->insert(array(
            array('name' => 'Laravel Personal Access Client', 'secret' => 'Xv97Ufl6dxBs2aAjjPk9gowawmVIECbBlFGkBgIY', 'redirect' => 'http://www.unclefitter.com', 'personal_access_client' => '1', 'password_client' => '0', 'revoked' => '0'),
            array('name' => 'Laravel Password Grant Client', 'secret' => 'Fi9MrfqVSJ9yBDxa2b5uf65huxvY3Iti4AziPPef', 'redirect' => 'http://www.unclefitter.com', 'personal_access_client' => '0', 'password_client' => '1', 'revoked' => '0'),
        ));

        DB::table('oauth_personal_access_clients')->delete();
        //insert some dummy records
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => '1',
        ]);
    }

}
