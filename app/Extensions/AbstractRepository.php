<?php

namespace App\Extensions;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    /**
     * @var Builder
     */
    protected $query;

    /**
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return Builder
     */
    abstract public function newQuery(): Builder;

    /**
     * @return AbstractRepository
     */
    public function reset(): self
    {
        $this->query = $this->newQuery();

        return $this;
    }

    /**
     * @param int $id
     * @return AbstractRepository
     */
    public function find(int $id): self
    {
        $this->query->find($id);

        return $this;
    }

    /**
     * @return Model|null
     */
    public function getOne(): ?Model
    {
        $result = $this->query->first();
        $this->reset();

        return $result;
    }

    /**
     * @param string $field
     * @return array
     */
    public function getAllGroupedBy(string $field): array
    {
        $result = $this->query
            ->get()
            ->map(function ($item) {
                return (array)$item;
            })
            ->groupBy($field)
            ->map(function ($collection) {
                return $collection->all();
            })
            ->all();
        $this->reset();
        return $result;
    }


    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        $results = $this->query->get();
        $this->reset();

        return $results;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $result = $this->query->count();
        $this->reset();
        return $result;
    }

    /**
     * @param string $field
     * @return array
     */
    public function getCountsGroupedBy(string $field): array
    {
        $result = $this->query
            ->select($field . ' as key')
            ->selectRaw('COUNT(*) as count')
            ->groupBy($field)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->count];
            })->all();
        $this->reset();
        return $result;
    }

    /**
     * @param int $limit
     * @return AbstractRepository
     */
    public function take(int $limit): self
    {
        $this->query->take($limit);
        return $this;
    }

    /**
     * @param int $skip
     * @return AbstractRepository
     */
    public function skip(int $skip): self
    {
        $this->query->skip($skip);
        return $this;
    }
}
