<?php

namespace App\Entity;

use App\Doctrine\Attribute\Filter;
use App\Doctrine\Filter\Strategy\SearchStrategy;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
#[Filter\Search('name')]
#[Filter\Search('location', strategy: SearchStrategy::Exact)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Serializer\Groups(groups: ['organisation-get', 'organisation-list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Serializer\Groups(groups: ['organisation-get', 'organisation-list'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Serializer\Groups(groups: ['organisation-get', 'organisation-list'])]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'organisation', targetEntity: OrganisationRelation::class)]
    #[Serializer\Ignore]
    private Collection $organisationRelations;

    public function __construct()
    {
        $this->organisationRelations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, OrganisationRelation>
     */
    public function getOrganisationRelations(): Collection
    {
        return $this->organisationRelations;
    }

    public function addOrganisationRelation(OrganisationRelation $organisationRelation): self
    {
        if (!$this->organisationRelations->contains($organisationRelation)) {
            $this->organisationRelations->add($organisationRelation);
            $organisationRelation->setOrganisation($this);
        }

        return $this;
    }

    public function removeOrganisationRelation(OrganisationRelation $organisationRelation): self
    {
        if ($this->organisationRelations->removeElement($organisationRelation)) {
            // set the owning side to null (unless already changed)
            if ($organisationRelation->getOrganisation() === $this) {
                $organisationRelation->setOrganisation(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
