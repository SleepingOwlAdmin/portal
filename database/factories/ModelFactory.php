<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        //'avatar' => function() {
        //    $files = File::files(base_path('databaseseeds/tmp'));
        //    $filePath = $files[array_rand($files)];
        //
        //    return new \Illuminate\Http\UploadedFile(
        //        $filePath, basename($filePath), 'image/jpeg', File::size($filePath)
        //    );
        //},
        'created_at' => $faker->dateTimeBetween('-1 year')
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(5),
        'text_intro' => $faker->safeEmail,
        'text_source' => $faker->sentence(5) . '<cut>'.$faker->randomElement(['Read more', 'More', 'Click to read'])
            .'</cut>'.PHP_EOL.'# Title'.PHP_EOL.$faker->sentence(10),
        'user_id' => function() {
            return App\User::first()->id;
        },
        //'upload_image' => function() {
        //    $files = File::files(base_path('database/seeds/tmp'));
        //    $filePath = $files[array_rand($files)];
        //
        //    return new \Illuminate\Http\UploadedFile(
        //        $filePath, basename($filePath), 'image/jpeg', File::size($filePath)
        //    );
        //},
        'created_at' => $faker->dateTimeBetween('-1 year')
    ];
});