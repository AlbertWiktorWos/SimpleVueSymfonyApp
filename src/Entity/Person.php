<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\LessThan('today')]
    private ?\DateTime $birthDate = null;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'person', orphanRemoval: true)]
    private Collection $contacts;

    /**
     * @var Collection<int, WorkExperience>
     */
    #[ORM\OneToMany(targetEntity: WorkExperience::class, mappedBy: 'person', orphanRemoval: true)]
    private Collection $workExperiences;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->workExperiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setPerson($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getPerson() === $this) {
                $contact->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkExperience>
     */
    public function getWorkExperiences(): Collection
    {
        return $this->workExperiences;
    }

    public function addWorkExperience(WorkExperience $workExperience): static
    {
        if (!$this->workExperiences->contains($workExperience)) {
            $this->workExperiences->add($workExperience);
            $workExperience->setPerson($this);
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): static
    {
        if ($this->workExperiences->removeElement($workExperience)) {
            // set the owning side to null (unless already changed)
            if ($workExperience->getPerson() === $this) {
                $workExperience->setPerson(null);
            }
        }

        return $this;
    }
}
