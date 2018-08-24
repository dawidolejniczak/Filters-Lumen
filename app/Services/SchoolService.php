<?php

namespace App\Services;


use App\Repository\SchoolRepository;
use App\Transformers\SchoolTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class SchoolService
{
    /**
     * @var int
     */
    private static $maxAmountPerPage = 25;

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
     * @return array
     */
    public function getFilteredSchools(Request $request): array
    {
        $schoolsQuery = $this->_initFilters($request);
        $schoolsCount = $schoolsQuery->getCount();

        $schoolsQuery = $this->_initFilters($request);
        $schools = $schoolsQuery->take(self::$maxAmountPerPage)->getAll();

        $results = fractal($schools, new SchoolTransformer())->toArray();

        $results['data']['schoolsCount'] = $schoolsCount;

        return $results;
    }

    /**
     * @param Request $request
     * @return SchoolRepository
     */
    private function _initFilters(Request $request): SchoolRepository
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

        return $schools;
    }
}