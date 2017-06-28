<?php

namespace App\Http\Controllers;

use EntityManager as EM;
use App\Entities\Thread;
use Illuminate\Http\Request;
use App\Repositories\ThreadRepository;
use App\Transformers\ThreadTransformer;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ThreadRepository $threads)
    {
        $threads = $threads->findAll();
        
        return fractal($threads, new ThreadTransformer)
            ->includeUser()->includeReplies();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thread = create(Thread::class, $request->all());

        EM::persist($thread);
    }

    /**
     * Display the specified resource.
     *
     * @param  Thread  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return fractal($thread, new ThreadTransformer)->includeUser()->includeReplies();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        update($thread, $request->all());

        EM::flush();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        EM::remove($thread);

        EM::flush();
    }
}
