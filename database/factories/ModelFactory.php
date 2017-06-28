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

/** @var \LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'          => $faker->name,
        'email'         => $faker->unique()->safeEmail,
        'password'      => $password ?: $password = bcrypt('secret'),
        'rememberToken' => str_random(10),
    ];
});

$factory->define(App\Entities\Channel::class, function (Faker\Generator $faker) {
    return [
        'name' => rtrim($faker->sentence(3), '.'),
    ];
});

$factory->define(App\Entities\Thread::class, function (Faker\Generator $faker) {
    $users    = EntityManager::getRepository(App\Entities\User::class)->findAll();
    $channels = EntityManager::getRepository(App\Entities\Channel::class)->findAll();

    $user    = $users
             ? $faker->randomElement($users)
             : entity(App\Entities\User::class)->create();

    $channel = $channels
             ? $faker->randomElement($channels)
             : entity(App\Entities\Channel::class)->create();

    return [
        'title'   => $faker->sentence,
        'body'    => $faker->text,
        'channel' => $channel,
        'user'    => $user,
    ];
});

$factory->define(App\Entities\Reply::class, function (Faker\Generator $faker) {
    $users   = EntityManager::getRepository(App\Entities\User::class)->findAll();
    $threads = EntityManager::getRepository(App\Entities\Thread::class)->findAll();

    $user   = $users
            ? $faker->randomElement($users)
            : entity(App\Entities\User::class)->create();

    $thread = $threads
            ? $faker->randomElement($threads)
            : entity(App\Entities\Thread::class)->create();

    return [
        'body'    => $faker->text,
        'thread'  => $thread,
        'user'    => $user,
    ];
});
