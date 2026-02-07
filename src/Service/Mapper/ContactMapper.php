<?php

namespace App\Service\Mapper;

use App\Entity\Contact;

class ContactMapper extends MapperAbstract
{

    public function getCode(): string
    {
        return 'contact';
    }
    public function map(array $data, object $entity): object
    {
        if(!$entity instanceof Contact){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Kontaktu.');
        }

        if (array_key_exists('email', $data)) {
            $entity->setEmail($data['email']);
        }

        if (array_key_exists('phone', $data)) {
            $entity->setPhone($data['phone']);
        }
        return $entity;
    }

    public function getEntityClass(): string
    {
        return Contact::class;
    }

}