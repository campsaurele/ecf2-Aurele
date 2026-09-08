<?php

namespace App\Entity;

use App\Repository\AbsencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsencesRepository::class)]
class Absences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateTime = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reasons $reason = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    private ?Trainee $trainee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getReason(): ?Reasons
    {
        return $this->reason;
    }

    public function setReason(?Reasons $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getTrainee(): ?Trainee
    {
        return $this->trainee;
    }

    public function setTrainee(?Trainee $trainee): static
    {
        $this->trainee = $trainee;

        return $this;
    }
}
