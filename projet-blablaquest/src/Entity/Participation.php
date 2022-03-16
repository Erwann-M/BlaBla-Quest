<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @Groups({"participation_browse", "user_browse_events", "user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"participation_browse", "user_browse_events", "user_read"})
     * @ORM\Column(type="boolean")
     */
    private $isValidated;

    /**
     * @Groups({"participation_browse", "user_browse_events", "user_read"})
     * @ORM\Column(type="boolean")
     */
    private $isRefused;

    /**
     * @Groups({"user_browse_events", "user_read"})
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @Groups({"participation_browse", "event_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->isRefused = false;
        $this->isValidated = false;
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

    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getIsRefused(): ?bool
    {
        return $this->isRefused;
    }

    public function setIsRefused(bool $isRefused): self
    {
        $this->isRefused = $isRefused;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
