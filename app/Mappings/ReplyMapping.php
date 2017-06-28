<?php

namespace App\Mappings;

use App\Entities\User;
use App\Entities\Reply;
use App\Entities\Thread;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\EntityMapping;

class ReplyMapping extends EntityMapping
{
    /**
     * Returns the fully qualified name of the class that this mapper maps.
     *
     * @return string
     */
    public function mapFor()
    {
        return Reply::class;
    }

    /**
     * Load the object's metadata through the Metadata Builder object.
     *
     * @param Fluent $builder
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->text('body');
        $builder->belongsTo(User::class);
        $builder->belongsTo(Thread::class)->inversedBy('replies');
        $builder->timestamps();
    }
}