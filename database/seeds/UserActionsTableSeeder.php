<?php

use Illuminate\Database\Seeder;

class UserActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User_action::class, 10)->create();
    }
}
