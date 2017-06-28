<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class ThreadRepository extends EntityRepository
{
    use Paginatable;
}
