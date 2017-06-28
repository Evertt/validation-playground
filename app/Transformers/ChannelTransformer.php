<?php

namespace App\Transformers;

use App\Entities\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Channel $channel)
    {
        return [
            'id'   => $channel->id,
            'slug' => $channel->slug,
            'name' => $channel->name,
        ];
    }
}
