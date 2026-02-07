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

    /**
     * Zwraca zmapowane encje na podstawie danych tablicowych.
     */
    public function mapEntitiesByData(array $data): array
    {
        $entities = [];
        foreach ($data as $code => $itemData) {

            $mapper = $this->getMapper($code);
            if(array_is_list($data) && $this->getMapper($code)->supportsCollections()){
                foreach($itemData as $key => $datum){
                    $data[$key] = $mapper->prepareEntityByData($datum);
                }
                $entities[$code] = $data;
                continue;
            }
            $entities[$code] = $this->prepareEntity($code, $itemData);
        }

        return $entities;
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
     * Mapuje dane tablicowe na encje.
     */
    public function prepareEntity(string $code, array $data): object
    {
        $mapper = $this->getMapper($code);
        if(!$mapper instanceof MapperAbstract){
            throw new \Exception("Nie udało się odnaleźć serwisu mapującego dla kodu '$code'.");
        }

        return $mapper->prepareEntityByData($data);
    }
}
