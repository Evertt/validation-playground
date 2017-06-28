<?php

namespace App\Mappings;

use App\Entities\User;
use App\Entities\Reply;
use App\Entities\Thread;
use App\Entities\Channel;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\EntityMapping;

class ThreadMapping extends EntityMapping
{
    /**
     * Returns the fully qualified name of the class that this mapper maps.
     *
     * @return string
     */
    public function mapFor()
    {
        return Thread::class;
    }

    /**
     * Load the object's metadata through the Metadata Builder object.
     *
     * @param Fluent $builder
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('title');
        $builder->text('body');

        $builder->hasMany(Reply::class)->mappedBy('thread');
        $builder->belongsTo(User::class);
        $builder->belongsTo(Channel::class);

        $builder->timestamps();
    }
}