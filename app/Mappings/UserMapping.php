<?php

namespace App\Mappings;

use App\Entities\User;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\EntityMapping;

class UserMapping extends EntityMapping
{
    /**
     * Returns the fully qualified name of the class that this mapper maps.
     *
     * @return string
     */
    public function mapFor()
    {
        return User::class;
    }

    /**
     * Load the object's metadata through the Metadata Builder object.
     *
     * @param Fluent $builder
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('name');
        $builder->string('email')->unique();
        $builder->string('password');
        $builder->rememberToken();
        $builder->timestamps();
    }
}