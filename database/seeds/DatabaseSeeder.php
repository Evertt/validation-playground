<?php

use Illuminate\Database\Seeder;
use App\Entities\{User, Channel, Thread, Reply};

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        truncate_tables([
            Reply::class,
            Thread::class,
            Channel::class,
            User::class
        ]);

        entity(\App\Entities\User::class, 10)->create();
        entity(\App\Entities\Channel::class, 5)->create();
        entity(\App\Entities\Thread::class, 15)->create();
        entity(\App\Entities\Reply::class, 45)->create();
    }
}
