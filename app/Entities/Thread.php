<?php

namespace App\Entities;

use App\Helpers\MagicAccess;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Thread
{
    use MagicAccess;

    /** @var int */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $body;

    /** @var User */
    protected $user;

    /** @var Channel */
    protected $channel;

    /** @var Collection|Reply[] */
    protected $replies;

    /** @var \DateTime|null */
    protected $createdAt;

    /** @var \DateTime|null */
    protected $updatedAt;

    /**
     * Class Constructor
     * @param  string   $title
     * @param  string   $body
     * @param  User     $user
     * @param  Channel  $channel
     */
    public function __construct(string $title, string $body, User $user, Channel $channel)
    {
        $this->setTitle($title)->setBody($body)->setUser($user)->setChannel($channel);

        $this->replies = new ArrayCollection;
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
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param  string  $title the title
     *
     * @return self
     */
    protected function setTitle(string $title)
    {
        validate($title, 'min:3|max:255');

        $this->title = $title;

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
        validate($body, 'min:3|max:255');
        
        $this->body = $body;

        return $this;
    }

    /**
     * Gets the replies.
     *
     * @return Collection|Reply[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
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
     * Gets the value of channel.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * Sets the value of channel.
     *
     * @param Channel  $channel the channel
     *
     * @return self
     */
    protected function setChannel(Channel $channel)
    {
        $this->channel = $channel;

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