<?php

namespace App\Service\Mapper;

use App\Dto\PersonModel;
use App\Entity\Person;

class PersonMapper extends MapperAbstract
{
    public static function getDtoClass(): string
    {
        return PersonModel::class;
    }
    public function map(object $dto, object $entity): object
    {
        if(!$entity instanceof Person){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Osoby.');
        }

        $entity->setFirstName($dto->firstName);
        $entity->setLastName($dto->lastName);
        $entity->setBirthDate($dto->birthDate);

        return $entity;
    }


    public function getEntityClass(): string
    {
        return Person::class;
    }
}