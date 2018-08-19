<?php

use Illuminate\Database\Seeder;

final class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\City::class, 100)->create();
    }
}
