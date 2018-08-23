<?php

namespace App\Services;


use App\Repository\SchoolRepository;
use App\Transformers\SchoolTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class SchoolService
{
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;

    /**
     * SchoolsController constructor.
     * @param SchoolRepository $schoolRepository
     */
    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;

    }

    /**
     * @param Request $request
     * @return string
     */
    public function getFilteredSchools(Request $request): string
    {
        if ($request->has('categoriesCodes')) {
            $schools = $this->schoolRepository->whereHas('categories', function (Builder $query) use ($request) {
                $i = 0;
                foreach ($request->get('categoriesCodes') as $categoryCode) {
                    if ($i === 0) {
                        $query->where('name', '=', $categoryCode);
                    } else {
                        $query->orWhere('name', '=', $categoryCode);
                    }
                    $i++;
                }
            });
        }

        if (!isset($schools)) {
            $schools = $this->schoolRepository;
        }

        $schools = $schools->getAll();

        $results = fractal($schools, new SchoolTransformer())->toJson();

        return $results;
    }
}