<?php

namespace App\Service\Mapper;

use App\Dto\ContactModel;
use App\Entity\Contact;

class ContactMapper extends MapperAbstract
{

    public static function getDtoClass(): string
    {
        return ContactModel::class;
    }
    public function map(object $dto, object $entity): object
    {
        if(!$entity instanceof Contact){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Kontaktu.');
        }

        $entity->setEmail($dto->email);
        $entity->setPhone($dto->phone);

        return $entity;
    }

    public function getEntityClass(): string
    {
        return Contact::class;
    }

}