<?php

use Illuminate\Database\Seeder;

final class CategorySchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\School::class, 100)->create()->each(function (\App\Models\School $school) {
            $school->categories()->save(factory(\App\Models\Category::class)->make());
        });
    }
}
