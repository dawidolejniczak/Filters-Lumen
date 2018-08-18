<?php

namespace App\Http\Controllers;


use App\Repository\SchoolRepository;
use Illuminate\Http\Request;

final class SchoolsController extends Controller
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

    public function index(Request $request)
    {
        return $this->schoolRepository->getAll();
    }
}