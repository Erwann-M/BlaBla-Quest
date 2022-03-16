<?php

namespace App\Entity;

use App\Repository\EventRepository;
use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @Groups({"event_browse", "event_read", "event_browse", "user_read", "user_browse_events", "event_browseByArea"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"event_browse", "event_read", "event_browseByArea", "game_browse", "game_read", "event_browse", "user_read", "user_browse_events", "participation_browse"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"event_read"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups({"event_browse", "event_read", "user_browse_events", "event_browseByArea"})
     * @ORM\Column(type="datetime")
     */
    private $dateTime;

    /**
     * @Groups({"event_read", "user_browse_events", "event_browseByArea"})
     * @ORM\Column(type="integer")
     */
    private $entrantsNumbers;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    // /**
    //  * @ORM\ManyToMany(targetEntity=User::class, inversedBy="events")
    //  */
    // private $event;

    /**
     * @Groups({"event_browse", "event_read"})
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="event", orphanRemoval=true)
     */
    private $comments;

    /**
     * @Groups({"event_browse", "event_browseByArea", "event_read"})
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="event")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @Groups({"event_browse", "event_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="eventsCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * 
     * @Groups({"event_browse", "event_read", "event_browseByArea", "user_browse_events"})
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     *
     * @Groups({ "participation_browse", "event_read"})
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="event", orphanRemoval=true)
     */
    private $participations;

    /**
     * @Groups({"event_browse", "event_read", "event_browseByArea"})
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $status;

    /**
     * @Groups({"event_browse", "event_read", "event_browseByArea", "participation_browse", "user_browse_events"})
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $totalUsersValidated;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->totalUsersValidated = 1;
        $this->createdAt = new \DateTimeImmutable;
        $this->status = 0;
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

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getEntrantsNumbers(): ?int
    {
        return $this->entrantsNumbers;
    }

    public function setEntrantsNumbers(int $entrantsNumbers): self
    {
        $this->entrantsNumbers = $entrantsNumbers;

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
     * @return Collection|User[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(User $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
        }

        return $this;
    }

    public function removeEvent(User $event): self
    {
        $this->event->removeElement($event);

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

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

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setEvent($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEvent() === $this) {
                $participation->setEvent(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalUsersValidated(): ?int
    {
        return $this->totalUsersValidated;
    }

    public function setTotalUsersValidated(int $totalUsersValidated): self
    {
        $this->totalUsersValidated = $totalUsersValidated;

        return $this;
    }
}
