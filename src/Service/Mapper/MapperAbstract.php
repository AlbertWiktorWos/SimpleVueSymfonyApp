<?php

namespace App\Service\Mapper;

use Doctrine\ORM\EntityManagerInterface;

abstract class MapperAbstract
{

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    abstract public static function getDtoClass(): string;
    abstract public function map(object $dto, object $entity): ?object;
    abstract public function getEntityClass(): string;

    public function getIdField(): string
    {
        return 'id';
    }

    public function prepareEntityByData(object $dto): ?object
    {
        if (!$dto instanceof ($this->getDtoClass())) {
            throw new \InvalidArgumentException(sprintf(
                'Spodziewano DTO typu %s, %s otrzymano.',
                $this->getDtoClass(),
                get_debug_type($dto)
            ));
        }

        $entity = null;
        if(isset($dto->{$this->getIdField()})){
            $entity = $this->entityManager->getRepository($this->getEntityClass())->find($dto->{$this->getIdField()});
        }

        if($entity === null) {
            $entity = new ($this->getEntityClass())();
        }

        return $this->map($dto, $entity);
    }

}