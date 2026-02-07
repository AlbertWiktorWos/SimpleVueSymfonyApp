<?php

namespace App\Service\Mapper;

use Doctrine\ORM\EntityManagerInterface;

abstract class MapperAbstract
{

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    abstract public function getCode(): string;
    abstract public function map(array $data, object $entity): ?object;
    abstract public function getEntityClass(): string;

    public function getIdField(): string
    {
        return 'id';
    }

    public function prepareEntityByData(array $data): ?object
    {
        $entity = null;
        if(isset($data[$this->getIdField()])){
            $entity = $this->entityManager->getRepository($this->getEntityClass())->find($data[$this->getIdField()]);
        }

        if($entity === null) {
            $entity = new ($this->getEntityClass())();
        }

        if(empty($data)) {
            return null;
        }
        return $this->map($data, $entity);
    }


    public function supportsCollections(): bool
    {
        return false;
    }

}