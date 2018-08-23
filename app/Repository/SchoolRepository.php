<?php

namespace App\Repository;


use App\Extensions\AbstractRepository;
use App\Models\School;
use Illuminate\Database\Eloquent\Builder;

final class SchoolRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return School::query();
    }
}
