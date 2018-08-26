<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\Category;
use App\Models\School;
use Illuminate\Support\Collection;

class SchoolsTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex(): void
    {
        /** @var School $school */
        $school = $this->_seedSchoolsWithCategories()[0];

        $category = $school->categories()->first();

        $this
            ->get('/schools?categoriesCodes[]=' . urlencode($category->name))
            ->seeJson([
                'id' => $school->id
            ]);

        $this->assertResponseOk();
    }

    public function testShow(): void
    {
        /** @var School $school */
        $school = $this->_seedSchoolsWithCategories()[0];


        $this
            ->get('/schools/' . $school->id)
            ->seeJson([
                'name' => $school->name
            ]);

        $this->assertResponseOk();
    }

    public function testStore(): void
    {
        $postRequest = $this
            ->post('/schools', [
                'name' => 'test',
                'address' => 'test',
                'city_id' => 1234,
                'students_count' => 1234
            ]);

        $school = School::latest()->first();

        $postRequest->seeJson([
            'name' => $school->name
        ]);

        $this->assertResponseOk();
    }

    public function testUpdate(): void
    {
        $this->_seedSchoolsWithCategories();

        $this
            ->put('/schools/1', [
                'name' => 'test',
                'address' => 'test',
                'city_id' => 1234,
                'students_count' => 1234
            ])
            ->seeJson([
                'name' => 'test'
            ]);

        $this
            ->get('schools/1')
            ->seeJson(['name' => 'test']);

        $this->assertResponseOk();
    }

    public function testDelete(): void
    {
        $this->_seedSchoolsWithCategories();

        $this
            ->delete('/schools/1')
            ->seeJson([true]);

        $this
            ->get('/schools/1')
            ->seeJson([
                'status' => 400
            ]);
    }

    /**
     * @return Collection
     */
    private function _seedSchoolsWithCategories(): Collection
    {
        $schools = factory(School::class, 100)->create()->each(function (School $school) {
            $school->categories()->save(factory(Category::class)->make());
        });

        return $schools;
    }
}