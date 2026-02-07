<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormValidatorService
{
    public function __construct(private readonly ValidatorInterface $validator) {}

    /**
     * @param object[] $entities
     * @param string[]|null $groups
     * @return array|null  Zwraca tablicę błędów lub null jeśli brak błędów
     */
    public function validate(array $entities, ?array $groups = null): ?array
    {
        $allErrors = [];

        foreach ($entities as $key => $entity) {
            $errors = $this->validator->validate($entity, null, $groups ?? ['Default']);
            if (count($errors) > 0) {
                $allErrors[$key] = (string) $errors;
            }
        }

        return empty($allErrors) ? null : $allErrors;
    }
}
