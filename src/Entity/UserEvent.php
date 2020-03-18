<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersEventsRepository")
 */
class UsersEvents
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\users", mappedBy="usersEvents")
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\events", mappedBy="usersEvents")
     */
    private $event_id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_read;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->event_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|users[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(users $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setUsersEvents($this);
        }

        return $this;
    }

    public function removeUserId(users $userId): self
    {
        if ($this->user_id->contains($userId)) {
            $this->user_id->removeElement($userId);
            // set the owning side to null (unless already changed)
            if ($userId->getUsersEvents() === $this) {
                $userId->setUsersEvents(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|events[]
     */
    public function getEventId(): Collection
    {
        return $this->event_id;
    }

    public function addEventId(events $eventId): self
    {
        if (!$this->event_id->contains($eventId)) {
            $this->event_id[] = $eventId;
            $eventId->setUsersEvents($this);
        }

        return $this;
    }

    public function removeEventId(events $eventId): self
    {
        if ($this->event_id->contains($eventId)) {
            $this->event_id->removeElement($eventId);
            // set the owning side to null (unless already changed)
            if ($eventId->getUsersEvents() === $this) {
                $eventId->setUsersEvents(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }
}
