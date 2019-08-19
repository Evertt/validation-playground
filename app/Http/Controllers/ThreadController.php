<?php

namespace App\Http\Controllers;

use App\Entities\Thread;
use Illuminate\Http\Request;
use App\Repositories\ThreadRepository;
use App\Transformers\ThreadTransformer;

class ThreadController extends Controller
{
    /**
     * @var ThreadRepository
     */
    protected $threadsRepo;

    /**
     * ThreadController constructor.
     * @param ThreadRepository $threadsRepo
     */
    public function __construct(ThreadRepository $threadsRepo)
    {
        $this->threadsRepo = $threadsRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->threadsRepo->findAll();
        
        return fractal($threads, new ThreadTransformer)
            ->includeUser()->includeReplies();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->threadsRepo->add($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  Thread  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return fractal($thread, new ThreadTransformer)
            ->includeUser()->includeReplies();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Thread  $thread
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        $this->threadsRepo->update($thread, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Thread  $thread
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $this->threadsRepo->remove($thread);
    }
}
