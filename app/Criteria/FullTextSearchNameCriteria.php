<?php

namespace App\Criteria;


use Illuminate\Database\Eloquent\Builder;

final class FullTextSearchNameCriteria implements CriteriaInterface
{

    public function apply(Builder $query, ...$params): Builder
    {
        $text = $params[0];

        if ($text != null) {
            $query = $query->where('name', 'like', '%' . $text . '%');
        }

        return $query;
    }
}