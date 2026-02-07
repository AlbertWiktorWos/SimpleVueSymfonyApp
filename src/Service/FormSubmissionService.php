<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Serwis odpowiedzialny za obsługę procesu związanego z przesłanymi danymi formularza
 */
class FormSubmissionService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MapperManager $mapper,
        private readonly FormValidatorService $validatorService
    ) {}

    /**
     * @param array $rawData surowe dane przesłane z formularza, np. w formie tablicy asocjacyjnej
     * @param array|null $validationGroups opcjonalne grupy walidacyjne do użycia podczas sprawdzania poprawności danych
     * @return array tablica z kluczem 'success' (bool) oraz opcjonalnie 'errors' (tablica błędów walidacji)
     */
    public function submitForm(array $rawData, ?array $validationGroups = null): array
    {

        $entities = $this->mapper->mapEntitiesByData($rawData);
        $errors = $this->validatorService->validate($entities, $validationGroups);

        if ($errors) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        foreach($entities as $entity){
            if(is_array($entity)){
                foreach ($entity as $e){
                    $this->em->persist($e);
                }
                continue;
            }

            $this->em->persist($entity);
        }

        $this->em->flush();

        return [
            'success' => true,
        ];
    }
}
