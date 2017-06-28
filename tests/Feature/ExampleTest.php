<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\Thread;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTesttt()
    {
        $thread = entity(Thread::class, 1)->create();

        $otherThread = $this->app['em']->find(Thread::class, 1);

        $this->assertEquals($thread, $otherThread);
        
        $response = $this->get('/api/threads');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest2()
    {
        $otherThread = $this->app['em']->find(Thread::class, 1);

        $this->assertNull($otherThread);

        $response = $this->get('/api/threads');

        $response->assertStatus(200);
    }
}
