<?php

namespace App\Service;

use App\Dto\ContactModel;
use App\Dto\PersonModel;
use App\Dto\WorkExperienceModel;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AppFormDtoFactory
{
    public function __construct(private readonly SerializerInterface $serializer) {}

    public function createPersonModelFromJson(string $json): PersonModel
    {
        return $this->serializer->deserialize($json, PersonModel::class, 'json', [
            AbstractNormalizer::CALLBACKS => [
                'workExperiences' => fn(array $items) => array_map(
                    fn($we) => $this->serializer->denormalize($we, WorkExperienceModel::class),
                    $items
                )
            ],
        ]);
    }
}