<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{
    public ?int $id = null;

    #[Assert\NotBlank(message: "E-mail jest wymagany")]
    #[Assert\Email(message: "Niepoprawny adres e-mail")]
    #[Assert\Length(max: 100)]
    public string $email;

    #[Assert\NotBlank(message: "Telefon jest wymagany")]
    #[Assert\Regex(
        pattern: '/^\+?[0-9\s\-]{7,20}$/',
        message: "Niepoprawny numer telefonu"
    )]
    #[Assert\Length(max: 20)]
    public string $phone;

    /**
     * @param string $email
     * @param string $phone
     * @param int|null $id
     */
    public function __construct(string $email, string $phone, ?int $id = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->phone = $phone;
    }


}
