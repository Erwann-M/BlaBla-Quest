DANS ENTITY USER :

    /**
     * @Groups({"user_read", "user_browse_events"})
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="users")
     */
    private $events;

        public function __construct()
    {
        $this->events = new ArrayCollection(); supprimé
        $this->comments = new ArrayCollection();
        $this->eventsCreated = new ArrayCollection();
    }


        /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addEvent($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeEvent($this);
        }

        return $this;
    }


    DANS ENTITY EVENT :

        /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $users;


        public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->users = new ArrayCollection(); SUPPRIME
    }

        /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }