<?php

namespace App\Repositories;

use App\Validation\ValidatorFactory;
use Symfony\Component\Serializer\Serializer;
use LaravelDoctrine\ORM\Pagination\Paginatable;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class EntityRepository extends DoctrineEntityRepository
{
    use Paginatable;

    /**
     * @param mixed $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($entity)
    {
        if (is_array($entity)) {
            $entity = $this->fill($this->_entityName, $entity);
        }

        $this->_em->persist($entity);

        $this->_em->flush($entity);
    }

    /**
     * @param mixed $entity
     * @param array $data
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($entity, array $data)
    {
        $this->fill($entity, $data);

        $this->_em->flush($entity);
    }

    /**
     * @param mixed $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($entity)
    {
        $this->_em->remove($entity);

        $this->_em->flush($entity);
    }

    /**
     * Makes an entity with some data.
     *
     * @param  string|object        $entity  The entity
     * @param  array                $data    The data
     */
    private function fill($entity, array $data)
    {
        $context = [];

        if (!is_string($entity)) {
            $context = ['object_to_populate' => $entity];
            $entity  = get_class($entity);
        }

        return ValidatorFactory::makeAndForget(
            function() use ($data, $entity, $context) {
                $normalizer = new ObjectNormalizer();
                $serializer = new Serializer([$normalizer], []);

                $entity = $serializer->denormalize($data, $entity, null, $context);

                ValidatorFactory::make($entity)->throwErrors();

                return $entity;
            }, true
        );
    }
}
