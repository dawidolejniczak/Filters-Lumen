<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class School extends Model
{
    /**
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:3|max:255',
        'address' => 'required|string|min:3|max:255',
        'phone_number' => 'nullable|min:9|max:255',
        'email_address' => 'nullable|email|min:3|max:255',
        'city_id' => 'required|integer',
        'students_count' => 'required|integer',
    ];

    protected $fillable = [
        'name', 'address', 'phone_number', 'email_address', 'city_id', 'students_count'
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}