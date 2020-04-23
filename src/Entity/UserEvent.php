<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserEventRepository")
 * @ApiFilter(SearchFilter::class, properties={"user.id": "exact"})
 * @ORM\Table(name="users_events")
 */
class UserEvent
{
    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userEvents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     */
    private $is_read = false;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return mixed
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }
}
