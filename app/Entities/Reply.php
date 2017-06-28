<?php

namespace App\Entities;

use App\Helpers\MagicAccess;

class Reply
{
    use MagicAccess;

    /** @var int */
    protected $id;

    /** @var Thread */
    protected $thread;

    /** @var string */
    protected $body;

    /** @var User */
    protected $user;

    /** @var \DateTime|null */
    protected $createdAt;

    /** @var \DateTime|null */
    protected $updatedAt;

    /**
     * Class Constructor
     * @param  string  $thread
     * @param  string  $body
     * @param  User    $user
     */
    public function __construct(Thread $thread, string $body, User $user)
    {
        $this->setThread($thread)->setBody($body)->setUser($user);
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
     * Gets the value of thread.
     *
     * @return Thread
     */
    public function getThread(): Thread
    {
        return $this->thread;
    }

    /**
     * Sets the value of thread.
     *
     * @param  Thread  $thread the thread
     *
     * @return self
     */
    protected function setThread(Thread $thread)
    {
        validate($thread, 'max:255');

        $this->thread = $thread;

        return $this;
    }

    /**
     * Gets the value of body.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Sets the value of body.
     *
     * @param  string  $body the body
     *
     * @return self
     */
    protected function setBody(string $body)
    {
        validate($body, 'max:255');
        
        $this->body = $body;

        return $this;
    }

    /**
     * Gets the value of user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Sets the value of user.
     *
     * @param  User  $user the user
     *
     * @return self
     */
    protected function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets the value of createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets the value of updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}