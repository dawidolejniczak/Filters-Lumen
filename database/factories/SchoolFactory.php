<?php

$factory->define(\App\Models\School::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'phone_number' => $faker->phoneNumber,
        'email_address' => $faker->email,
        'city_id' => $faker->numberBetween(1, 100),
        'students_count' => $faker->numberBetween(1)
    ];
});
