<?php

use App\Models\School;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Transformers\SchoolTransformer;

class SchoolTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function testTransform(): void
    {
        $school = factory(School::class, 1)->create()->first();

        $transformer = (new SchoolTransformer())->transform($school);

        $this->assertEquals([
            'id', 'name', 'address', 'emailAddress', 'phoneNumber', 'studentsCount', 'categories', 'city'
        ], array_keys($transformer));
    }
}