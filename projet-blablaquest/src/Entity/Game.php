<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"event_browse", "event_read", "game_browse", "game_read", "event_browse", "event_browseByArea"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups({"game_browse", "game_read", "event_browse", "event_read", "event_browseByArea", "user_browse_events"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Groups({"game_browse", "game_read", "event_browse", "event_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $playtime;

    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\Column(type="smallint")
     */
    private $playersMin;

    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\Column(type="smallint")
     */
    private $playersMax;

    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\Column(type="smallint")
     */
    private $ageMin;

    /**
     * @Groups({"game_browse", "game_read"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @Groups({"game_browse", "game_read"})
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"game_browse", "game_read", "event_read"})
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="game")
     */
    private $categories;

    /**
     * @Groups({"game_browse", "game_read"})
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="game", orphanRemoval=true)
     */
    private $event;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable;
    }

    public function __toString()
    {
        return $this->name;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPlaytime(): ?string
    {
        return $this->playtime;
    }

    public function setPlaytime(?string $playtime): self
    {
        $this->playtime = $playtime;

        return $this;
    }

    public function getPlayersMin(): ?int
    {
        return $this->playersMin;
    }

    public function setPlayersMin(int $playersMin): self
    {
        $this->playersMin = $playersMin;

        return $this;
    }

    public function getPlayersMax(): ?int
    {
        return $this->playersMax;
    }

    public function setPlayersMax(int $playersMax): self
    {
        $this->playersMax = $playersMax;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addGame($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeGame($this);
        }

        return $this;
    }



    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setGame($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getGame() === $this) {
                $event->setGame(null);
            }
        }

        return $this;
    }
}
