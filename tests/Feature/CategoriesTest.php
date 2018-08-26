<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\Category;

class CategoriesTest extends TestCase
{
    use DatabaseMigrations;

    public function testSearch(): void
    {
        $category = factory(Category::class, 1)->create()->first();

        $this
            ->get('/categories?name=' . urlencode($category->name))
            ->seeJson([
                'name' => $category->name
            ]);

        $this->assertResponseOk();
    }

    public function testPagination(): void
    {
        $categories = factory(Category::class, 10)->create();

        $this
            ->get('/categories?offset=1&limit=1')
            ->seeJson([
                'name' => $categories[1]->name
            ])
            ->dontSeeJson([
                'name' => $categories[2]->name
            ])
            ->dontSeeJson([
                'name' => $categories[0]->name
            ]);

        $this->assertResponseOk();
    }
}