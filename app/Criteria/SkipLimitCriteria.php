<?php

namespace App\Criteria;


use Illuminate\Database\Eloquent\Builder;

final class SkipLimitCriteria implements CriteriaInterface
{
    /**
     * @param Builder $query
     * @param mixed ...$params
     * @return Builder
     */
    public function apply(Builder $query, ...$params): Builder
    {
        $skip = $params[0];
        $limit = $params[1];

        if ($skip !== null && $limit !== null) {
            $query = $query->skip($skip)->limit($limit);
        }

        return $query;
    }
}
