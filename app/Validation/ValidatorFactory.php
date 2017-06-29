<?php

namespace App\Validation;

class ValidatorFactory
{
    private static $stack = [];
    private static $saves = [];

    public static function make($entity)
    {
        $app = app();

        $validator = 'validator.' . spl_object_hash($entity);

        if ($count = count(static::$stack)) {
            static::$stack[$count-1][] = $validator;
        }

        if (!$app->bound($validator)) {
            $app->instance($validator, new Validator($entity));
        }

        if (end(static::$saves)) {
            $app[$validator]->holdErrors();
        }

        return $app[$validator];
    }

    public static function makeAndForget(callable $cb, $holdErrors = false)
    {
        static::$stack[] = [];
        static::$saves[] = $holdErrors;

        $cb();

        foreach(array_pull(static::$stack) as $key) {
            app()->forgetInstance($key);
        }

        array_pull(static::$saves);
    }
}
