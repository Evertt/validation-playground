<?php

namespace App\Transformers;

use App\Entities\Thread;
use League\Fractal\TransformerAbstract;

class ThreadTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'replies', 'user', 'channel'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Thread $thread)
    {
        return [
            'id'    => $thread->id,
            'title' => $thread->title,
            'body'  => $thread->body,
            'channel_id' => $thread->channel->id,
            // 'replies_count' => $thread->replies->count(),
        ];
    }

    /**
     * Include Replies
     *
     * @return League\Fractal\ItemResource
     */
    public function includeReplies(Thread $thread)
    {
        $replies = $thread->replies;

        return $this->collection($replies, new ReplyTransformer);
    }

    /**
     * Include User
     *
     * @return League\Fractal\ItemResource
     */
    public function includeUser(Thread $thread)
    {
        $user = $thread->user;

        return $this->item($user, new UserTransformer);
    }

    /**
     * Include Channel
     *
     * @return League\Fractal\ItemResource
     */
    public function includeChannel(Thread $thread)
    {
        $channel = $thread->channel;

        return $this->item($channel, new ChannelTransformer);
    }
}
