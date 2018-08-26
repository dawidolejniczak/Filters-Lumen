<?php

namespace App\Http\Controllers;


use App\Criteria\FullTextSearchNameCriteria;
use App\Criteria\SkipLimitCriteria;
use App\Repository\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CategoriesController extends Controller
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $this
            ->categoryRepository
            ->pushCriteria(new FullTextSearchNameCriteria(), $request->get('name'))
            ->pushCriteria(new SkipLimitCriteria(), $request->get('offset'), $request->get('limit'));

        $categories = $this->categoryRepository->getAll()->toArray();

        return response()->json($categories);
    }
}
