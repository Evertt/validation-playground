<?php

namespace App\Entities;

use App\Helpers\MagicAccess;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, MagicAccess;
    
    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /** @var email */
    protected $email;

    /** @var string */
    protected $password;

    /** @var string */
    protected $rememberToken;

    /** @var \DateTime|null */
    protected $createdAt;

    /** @var \DateTime|null */
    protected $updatedAt;

    public function __construct(string $name, string $email, string $password)
    {
        $this->setName($name)->setEmail($email)->setPassword($password);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        validate($name, 'required|max:255');

        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        validate($email, 'required|email|max:255');

        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        validate($password, 'required|min:6');

        $this->password = bcrypt($password);

        return $this;
    }
}
