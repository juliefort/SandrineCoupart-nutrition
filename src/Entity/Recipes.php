<?php

namespace App\Entity;

use App\Repository\RecipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: RecipesRepository::class)]
#[Vich\Uploadable]
class Recipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $timeMade = null;

    #[ORM\Column(length: 255)]
    private ?string $restingTime = null;

    #[ORM\Column(length: 255)]
    private ?string $cookingTime = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ingredients = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $steps = null;

    #[ORM\ManyToMany(targetEntity: Allergens::class, inversedBy: 'recipes', cascade: ['persist'])]
    private Collection $allergens;

    #[ORM\ManyToMany(targetEntity: Diet::class, inversedBy: 'recipes', cascade: ['persist'])]
    private Collection $diet;

    #[Vich\UploadableField(mapping: 'recipes', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'recipes', cascade: ['persist', 'remove'])]
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTimeMade(): ?string
    {
        return $this->timeMade;
    }

    public function setTimeMade(string $timeMade): static
    {
        $this->timeMade = $timeMade;

        return $this;
    }

    public function getRestingTime(): ?string
    {
        return $this->restingTime;
    }

    public function setRestingTime(string $restingTime): static
    {
        $this->restingTime = $restingTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(string $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getSteps(): ?string
    {
        return $this->steps;
    }

    public function setSteps(string $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * @return Collection<int, allergens>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(allergens $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(allergens $allergen): static
    {
        $this->allergens->removeElement($allergen);

        return $this;
    }

    /**
     * @return Collection<int, diet>
     */
    public function getDiet(): Collection
    {
        return $this->diet;
    }

    public function addDiet(diet $diet): static
    {
        if (!$this->diet->contains($diet)) {
            $this->diet->add($diet);
        }

        return $this;
    }

    public function removeDiet(diet $diet): static
    {
        $this->diet->removeElement($diet);

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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
            $review->setRecipes($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getRecipes() === $this) {
                $review->setRecipes(null);
            }
        }

        return $this;
    }

}


