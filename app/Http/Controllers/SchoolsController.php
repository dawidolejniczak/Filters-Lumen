<?php

namespace App\Http\Controllers;


use App\Exceptions\ModelDoesNotExistException;
use App\Models\School;
use App\Repository\SchoolRepository;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class SchoolsController extends Controller
{
    /**
     * @var SchoolRepository
     */
    private $schoolService;

    /**
     * @var SchoolRepository
     */
    private $schoolRepository;


    /**
     * SchoolsController constructor.
     * @param SchoolService $schoolService
     * @param SchoolRepository $schoolRepository
     */
    public function __construct(SchoolService $schoolService, SchoolRepository $schoolRepository)
    {
        $this->schoolService = $schoolService;
        $this->schoolRepository = $schoolRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $schools = $this->schoolService->getFilteredSchools($request);
            return response()->json($schools);

        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $school = $this->schoolRepository->find($id)->getOne();
            if (!$school) {
                throw new ModelDoesNotExistException();
            }

            return response()->json($school->toArray());
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), School::$rules);
            $this->checkValidation($validator);

            $school = $this->schoolRepository->create($request->all());

            return response()->json($school->toArray());
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }


    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), School::$rules);
            $this->checkValidation($validator);

            $school = $this->schoolRepository->find($id)->getOne();
            if (!$school) {
                throw new ModelDoesNotExistException();
            }
            $school->update($request->all());
            $school = $this->schoolRepository->find($id)->getOne();

            return response()->json($school->toArray());
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $school = $this->schoolRepository->find($id)->getOne();
            if (!$school) {
                throw new ModelDoesNotExistException();
            }
            $school->delete();

            return response()->json(true);
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }
}