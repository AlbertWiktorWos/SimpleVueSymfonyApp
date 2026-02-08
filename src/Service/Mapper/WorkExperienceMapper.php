<?php

namespace App\Service\Mapper;

use App\Dto\WorkExperienceModel;
use App\Entity\WorkExperience;

class WorkExperienceMapper extends MapperAbstract
{

    public static function getDtoClass(): string
    {
        return WorkExperienceModel::class;
    }
    public function map(object $dto, object $entity): object
    {
        if(!$entity instanceof WorkExperience){
            throw new \Exception('Nie można zmapować danych na encję, ponieważ nie jest ona instancją klasy Doświadczenia zawodowego.');
        }

        $entity->setCompany($dto->company);
        $entity->setPosition($dto->position);
        $entity->setDateFrom($dto->dateFrom);
        $entity->setDateTo($dto->dateTo);

        return $entity;
    }

    public function getEntityClass(): string
    {
        return WorkExperience::class;
    }


}