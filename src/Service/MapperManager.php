<?php

namespace App\Service;

use App\Service\Mapper\MapperAbstract;
use Symfony\Component\DependencyInjection\ServiceLocator;

class MapperManager
{
    public function __construct(
        // creates a service locator with all the services tagged with 'app.handler'
        private ServiceLocator $locator,
    ) {
    }

    public function getMapper(string $code): ?MapperAbstract
    {
        if ($this->getMapperLocator()->has($code)) {
            return $this->getMapperLocator()->get($code);
        }

        return null;
    }

    public function getMapperLocator(): ServiceLocator
    {
        return $this->locator;
    }


    /**
     * Mapuje dane DTO na encje.
     */
    public function mapEntityByDTO(object $data): object
    {
        $mapper = $this->getMapper($data::class);
        if(!$mapper instanceof MapperAbstract){
            throw new \Exception("Nie udało się odnaleźć serwisu mapującego dla klasy ".$data::class.".");
        }

        return $mapper->prepareEntityByData($data);
    }
}
