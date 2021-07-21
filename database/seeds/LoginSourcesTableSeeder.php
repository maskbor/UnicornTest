<?php

use Illuminate\Database\Seeder;

class LoginSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Login_source::class, 100)->create();
    }
}
