<?php

namespace App\Repository;


use App\Extensions\AbstractRepository;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;

class CityRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return City::query();
    }
}
