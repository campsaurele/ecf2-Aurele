<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Trainee>
     */
    #[ORM\OneToMany(targetEntity: Trainee::class, mappedBy: 'training')]
    private Collection $trainees;

    public function __construct()
    {
        $this->trainees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Trainee>
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): static
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees->add($trainee);
            $trainee->setTraining($this);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): static
    {
        if ($this->trainees->removeElement($trainee)) {
            // set the owning side to null (unless already changed)
            if ($trainee->getTraining() === $this) {
                $trainee->setTraining(null);
            }
        }

        return $this;
    }
}
