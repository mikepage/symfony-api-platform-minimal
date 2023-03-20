<?php

namespace App\Entity;

use App\Repository\OrganisationRelationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: OrganisationRelationRepository::class)]
class OrganisationRelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Serializer\Groups(groups: ['organisation-relation-get', 'organisation-relation-list'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Serializer\Groups(groups: ['organisation-relation-get', 'organisation-relation-list'])]
    private ?bool $archived = false;

    #[ORM\ManyToOne(inversedBy: 'organisationRelations')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    #[Serializer\Groups(groups: ['organisation-relation-get', 'organisation-relation-list'])]
    private ?Organisation $organisation = null;

    #[ORM\ManyToOne(inversedBy: 'organisationRelations')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'set null')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): self
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
