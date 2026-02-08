<?php

namespace App\Service;

use App\Dto\PersonModel;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Serwis odpowiedzialny za obsługę procesu związanego z przesłanymi danymi formularza
 */
class AppFormSubmissionService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $em,
        private readonly ValidatorInterface $validator,
        private readonly MapperManager $mapperManager,
        private readonly SerializerInterface $serializer
    ) {}

    /**
     * @param PersonModel $personModel dane przesłane z formularza, zmapowane na obiekt DTO
     * @param array|null $validationGroups opcjonalne grupy walidacyjne do użycia podczas sprawdzania poprawności danych
     * @return array tablica z kluczem 'success' (bool) oraz opcjonalnie 'errors' (tablica błędów walidacji)
     */
    public function submitAppForm(PersonModel $personModel, ?array $validationGroups = null): array
    {

        $errors = $this->validator->validate($personModel, null, $validationGroups ?? ['Default']);
        $errorsResult = [];
        if (count($errors) > 0) {

            foreach ($errors as $violation) {
                $errorsResult[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return [
                'success' => false,
                'errors' => $errorsResult
            ];
        }

        $this->mapPersonModelToEntity($personModel);

        return [
            'success' => true,
            'data' => $this->serializer->normalize($personModel, 'json', [
                'datetime_format' => 'Y-m-d'
            ])
        ];
    }

    /**
     * Mapuje dane z DTO PersonModel na encję Person oraz powiązane encje Contact i WorkExperience, a następnie zapisuje je w bazie danych.
     *
     * @param PersonModel $Model
     */
    public function mapPersonModelToEntity(PersonModel $Model): void
    {
        try {
            // Mapowanie osoby
            $person = $this->mapperManager->mapEntityByDTO($Model);
            // Mapowanie kontaktu
            $contact = $this->mapperManager->mapEntityByDTO($Model->contact);
            $this->em->persist($contact);

            $person->addContact($contact);

            // Mapowanie doświadczenia zawodowego
            foreach ($Model->workExperiences as $workExperienceModel) {
                $workExperience = $this->mapperManager->mapEntityByDTO($workExperienceModel);
                $this->em->persist($workExperience);
                $person->addWorkExperience($workExperience);
            }

            $this->em->persist($person);
            $this->em->flush();

        }catch (\Exception $e) {
            // Logowanie błędu mapowania
            $this->logger->error('Błąd mapowania formularza rekrutacyjnego: ' . $e->getMessage());
            throw new \RuntimeException('Błąd mapowania danych formularza: ' . $e->getMessage());
        }
    }

}