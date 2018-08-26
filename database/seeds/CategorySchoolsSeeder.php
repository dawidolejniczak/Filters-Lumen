<?php

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Category;

final class CategorySchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(School::class, 100)->create()->each(function (School $school) {
            $school->categories()->save(factory(Category::class)->make());
        });
    }
}
