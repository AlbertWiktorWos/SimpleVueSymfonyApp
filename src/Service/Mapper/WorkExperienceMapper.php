<?php

namespace App\Service\Mapper;

use App\Entity\Contact;
use App\Entity\WorkExperience;

class WorkExperienceMapper extends MapperAbstract
{

    public function getCode(): string
    {
        return 'work_experience';
    }
    public function map(array $data, object $entity): object
    {
        if(!$entity instanceof WorkExperience){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Doświadczenia zawodowego.');
        }

        if (array_key_exists('company', $data)) {
            $entity->setCompany($data['company']);
        }

        if (array_key_exists('position', $data)) {
            $entity->setPosition($data['position']);
        }

        if (array_key_exists('dateFrom', $data)) {
            $entity->setDateFrom(new \DateTime($data['dateFrom']));
        }

        if (array_key_exists('dateTo', $data)) {
            $entity->setDateTo(new \DateTime($data['dateTo']));
        }
        return $entity;
    }

    public function getEntityClass(): string
    {
        return WorkExperience::class;
    }

    public function supportsCollections(): bool
    {
        return true;
    }

}