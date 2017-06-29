<?php

// use App\Helpers\ObjectNormalizer;
use App\Validation\Validator;
use App\Validation\ValidatorFactory;
use Illuminate\Support\MessageBag;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Exceptions\ValidationException;
use Symfony\Component\Serializer\Serializer;

if (! function_exists('validate')) {
    /**
     * Validates data or a scalar value.
     *
     * @param  mixed  $value
     * @param  mixed  $rules
     * @param  array  $messages
     * @return void
     *
     * @throws ValidationException
     */
    function validate($value, $rules, array $messages = [])
    {
        if (!is_array($rules)) {
            $field = get_argument_name(0) ?: 'field';

            $value = [$field => $value];
            $rules = [$field => $rules];
        }
        
        $entity = debug_backtrace()[1]['object'];
        ValidatorFactory::make($entity)->validate($value, $rules, $messages);
    }
}

if (! function_exists('get_argument_name')) {
    /**
     * Get the name of the variable with which the function was called.
     *
     * @param  int     $index
     * @return string
     */
    function get_argument_name(int $index): string
    {
        $info = debug_backtrace()[1];

        $file = new SplFileObject($info['file']);

        $file->seek($info['line'] - 1);

        $line = $file->current();

        // @TODO: replace this naive implementation with token_get_all.

        preg_match("/$info[function]\((.+?)\);/", $line, $match);

        $argument = trim(explode(',', $match[1])[$index]);

        if (!starts_with($argument, '$')) return false;

        return ltrim($argument, '$');
    }
}

if (! function_exists('make')) {
    /**
     * Makes an entity with some data.
     *
     * @param  string|object        $entity  The entity
     * @param  array                $data    The data
     *
     * @throws ValidationException
     */
    function make($entity, array $data)
    {
        $context = [];

        if (!is_string($entity)) {
            $context = ['object_to_populate' => $entity];
            $entity  = get_class($entity);
        }
        
        ValidatorFactory::makeAndForget(
            function() use ($data, $entity, $context) {
                $normalizer = new ObjectNormalizer();
                $serializer = new Serializer([$normalizer], []);

                $entity = $serializer->denormalize($data, $entity, null, $context);

                ValidatorFactory::make($entity)->throwErrors();
            }, true
        );
    }
}

if (! function_exists('update')) {
    /**
     * Updates an entity with some data.
     *
     * @param  string|object        $entity  The entity
     * @param  array                $data    The data
     *
     * @throws ValidationException
     */
    function update($entity, array $data)
    {
        return make($entity, $data);
    }
}

if (! function_exists('classes_in_namespace')) {
    /**
     * Get all classes inside a certain namespace.
     *
     * @param  string    $namespace
     * @return string[]
     */
    function classes_in_namespace(string $namespace)
    {
        $a = include base_path('vendor/autoload.php');

        dd($a);
    }
}

if (! function_exists('truncate_table')) {
    /**
     * Truncate database table for a doctrine entity.
     *
     * @param  string  $entity
     */
    function truncate_table(string $entity)
    {
        $cmd = EntityManager::getClassMetadata($entity);
        $connection = EntityManager::getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}

if (! function_exists('truncate_tables')) {
    /**
     * Truncate database tables for doctrine entities.
     *
     * @param  string[]  $entities
     */
    function truncate_tables(array $entities)
    {
        array_walk($entities, 'truncate_table');
    }
}
