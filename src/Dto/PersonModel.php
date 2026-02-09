<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

class PersonModel
{


    public ?int $id = null;
    #[Assert\NotBlank(message: "Imię jest wymagane")]
    #[Assert\Length(max: 255)]
    public string $firstName;

    #[Assert\NotBlank(message: "Nazwisko jest wymagane")]
    #[Assert\Length(max: 255)]
    public string $lastName;

    #[Assert\NotBlank(message: "Data urodzenia jest wymagana")]
    #[Assert\LessThan("today", message: "Data urodzenia musi być wcześniejsza niż dzisiaj")]
    public ?\DateTime $birthDate;

    #[Assert\Valid]
    public ContactModel $contact;

    #[Assert\Count(min: 1, minMessage: "Należy wskazać co najmniej jedno doświadczenie zawodowe")]
    #[Assert\Valid]
    public array $workExperiences = [];

    /**
     * @param string $firstName
     * @param string $lastName
     * @param \DateTime|null $birthDate
     * @param ContactModel $contact
     * @param WorkExperienceModel|array $workExperiences
     * @param int|null $id
     */
    public function __construct(string $firstName, string $lastName, ?\DateTime $birthDate, ContactModel $contact, array $workExperiences, ?int $id = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->contact = $contact;
        $this->workExperiences = $workExperiences;
    }
}
