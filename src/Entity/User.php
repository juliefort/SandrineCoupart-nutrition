<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\ManyToMany(targetEntity: Allergens::class, inversedBy: 'users', cascade: ['persist', 'remove'])]
    private Collection $allergens;

    #[ORM\ManyToMany(targetEntity: Diet::class, inversedBy: 'users', cascade: ['persist', 'remove'])]
    private Collection $diet;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private Collection $review;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->diet = new ArrayCollection();
        $this->review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return Collection<int, Allergens>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergens $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(Allergens $allergen): static
    {
        $this->allergens->removeElement($allergen);

        return $this;
    }

    /**
     * @return Collection<int, Diet>
     */
    public function getDiet(): Collection
    {
        return $this->diet;
    }

    public function addDiet(Diet $diet): static
    {
        if (!$this->diet->contains($diet)) {
            $this->diet->add($diet);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): static
    {
        $this->diet->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->review->contains($review)) {
            $this->review->add($review);
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

}
