<?php

namespace App\Dto;

use App\Validator\DateRange;
use Symfony\Component\Validator\Constraints as Assert;

#[DateRange]
class WorkExperienceModel
{
    public ?int $id = null;
    #[Assert\NotBlank(message: "Firma jest wymagana")]
    #[Assert\Length(max: 255)]
    public string $company;

    #[Assert\NotBlank(message: "Stanowisko jest wymagane")]
    #[Assert\Length(max: 255)]
    public string $position;

    #[Assert\NotBlank(message: "Data rozpoczęcia jest wymagana")]
    public \DateTime $dateFrom;

    #[Assert\NotBlank(message: "Data zakończenia jest wymagana")]
    public \DateTime $dateTo;

    /**
     * @param string $company
     * @param string $position
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param int|null $id
     */
    public function __construct(string $company, string $position, \DateTime $dateFrom, \DateTime $dateTo, ?int $id = null)
    {
        $this->id = $id;
        $this->company = $company;
        $this->position = $position;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }


}
