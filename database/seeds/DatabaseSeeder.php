<?php

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySchoolsSeeder::class);
        $this->call(CitiesSeeder::class);
    }
}
