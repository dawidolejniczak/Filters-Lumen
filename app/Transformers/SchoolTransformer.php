<?php

namespace App\Transformers;


use App\Models\School;
use League\Fractal\TransformerAbstract;

final class SchoolTransformer extends TransformerAbstract
{
    public function transform(School $school): array
    {
        $categories = '';
        foreach ($school->categories()->get() as $category) {
            $categories = $category->name . ', ';
        }

        $categories = rtrim($categories, ', ');
        return [
            'id' => $school->id,
            'name' => $this->_cutBack($school->name),
            'address' => $this->_cutBack($school->address),
            'emailAddress' => $this->_cutBack($school->email_address),
            'phoneNumber' => $this->_cutBack($school->phone_number),
            'studentsCount' => $school->students_count,
            'categories' => $categories,
            'city' => $school->city()->first()->name
        ];
    }

    private function _cutBack(string $string)
    {
        return substr($string, 0, 5) . '*****';
    }
}