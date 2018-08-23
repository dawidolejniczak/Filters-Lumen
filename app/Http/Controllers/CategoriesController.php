<?php

namespace App\Http\Controllers;


use App\Criteria\FullTextSearchNameCriteria;
use App\Criteria\SkipLimitCriteria;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;

final class CategoriesController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $this
            ->categoryRepository
            ->pushCriteria(new FullTextSearchNameCriteria(), $request->get('name'))
            ->pushCriteria(new SkipLimitCriteria(), $request->get('offset'), $request->get('limit'));

        return $this->categoryRepository->getAll();
    }
}
