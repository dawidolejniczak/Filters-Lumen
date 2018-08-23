<?php

namespace App\Repository;


use App\Extensions\AbstractRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

final class CategoryRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return Category::query();
    }
}
