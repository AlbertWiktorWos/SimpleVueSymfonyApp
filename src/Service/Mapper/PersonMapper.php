<?php

namespace App\Service\Mapper;

use App\Entity\Person;

class PersonMapper extends MapperAbstract
{

    public function getCode(): string
    {
        return 'person';
    }
    public function map(array $data, object $entity): object
    {
        if(!$entity instanceof Person){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Osoby.');
        }

        if (array_key_exists('firstName', $data)) {
            $entity->setFirstName($data['firstName']);
        }

        if (array_key_exists('lastName', $data)) {
            $entity->setLastName($data['lastName']);
        }

        if (array_key_exists('birthDate', $data)) {
            $entity->setBirthDate(new \DateTime($data['birthDate']));
        }

        return $entity;
    }

    public function getEntityClass(): string
    {
        return Person::class;
    }

}