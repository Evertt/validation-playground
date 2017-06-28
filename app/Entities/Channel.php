<?php

namespace App\Entities;

use App\Helpers\MagicAccess;

class Channel
{
    use MagicAccess;

    /** @var int */
    protected $id;

    /** @var string */
    protected $slug;

    /** @var string */
    protected $name;

    /**
     * Class Constructor
     * @param  string  $thread
     * @param  string  $name
     * @param  User    $user
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Gets the value of id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the value of slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param  string  $name the name
     *
     * @return self
     */
    protected function setName(string $name)
    {
        validate($name, 'required|max:255');
        
        $this->name = $name;

        return $this;
    }
}