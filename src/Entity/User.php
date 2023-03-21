<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Serializer\Groups(groups: ['user-get', 'user-list'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Serializer\Groups(groups: ['user-get', 'user-list'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Serializer\Ignore]
    private array $roles = [];

    #[ORM\Column]
    #[Serializer\Ignore]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: OrganisationRelation::class)]
    #[Serializer\Groups(groups: ['user-get', 'user-list'])]
    private Collection $organisationRelations;

    public function __construct()
    {
        $this->organisationRelations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $organisationRelation->setUser($this);
        }

        return $this;
    }

    public function removeOrganisationRelation(OrganisationRelation $organisationRelation): self
    {
        if ($this->organisationRelations->removeElement($organisationRelation)) {
            // set the owning side to null (unless already changed)
            if ($organisationRelation->getUser() === $this) {
                $organisationRelation->setUser(null);
            }
        }

        return $this;
    }
}
