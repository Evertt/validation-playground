<?php

namespace App\Validation;

use Validator as LaravelValidator;
use Illuminate\Validation\ValidationException;

class Validator
{
    protected $data = [];

    protected $rules = [];

    protected $messages = [];

    protected $saveDontThrow = false;

    public function __construct($entity)
    {
        $this->data = $this->getData($entity);
    }

    public function holdErrors()
    {
        $this->saveDontThrow = true;
    }

    public function validate(array $data, array $rules, array $messages)
    {
        if ($this->saveDontThrow) {
            return $this->save($data, $rules, $messages);
        }

        $this->data = array_merge($this->data, $data);

        $validator = LaravelValidator::make($this->data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function save(array $data, array $rules, array $messages)
    {
        $this->data     = array_merge($this->data, $data);
        $this->rules    = array_merge($this->rules, $rules);
        $this->messages = array_merge($this->messages, $messages);
    }

    public function throwErrors()
    {
        $validator = LaravelValidator::make(
            $this->data, $this->rules, $this->messages
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->saveDontThrow = false;
    }

    protected function getData($entity)
    {
        $data = [];

        $mangledData = array_reverse((array) $entity);

        foreach($mangledData as $key => $value) {
            $keys = explode("\0", $key);
            $data[end($keys)] = $value;
        }

        return $data;
    }
}
