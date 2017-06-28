<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class ChannelRepository extends EntityRepository
{
    use Paginatable;
}
