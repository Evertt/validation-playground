<?php

namespace App\Transformers;

use App\Entities\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'user', 'thread'
    ];

    /**
     * List of resources to include by default
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Reply $reply)
    {
        return [
            'id'        => $reply->id,
            'body'      => $reply->body,
            'createdAt' => $reply->createdAt->format('c'),
        ];
    }

    /**
     * Include User
     *
     * @return League\Fractal\ItemResource
     */
    public function includeUser(Reply $reply)
    {
        $user = $reply->user;

        return $this->item($user, new UserTransformer);
    }

    /**
     * Include Thread
     *
     * @return League\Fractal\ItemResource
     */
    public function includeThread(Reply $reply)
    {
        $thread = $reply->thread;

        return $this->item($thread, new ChannelTransformer);
    }
}
