<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use \Ramsey\Uuid\UuidInterface;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     collectionOperations={
 *     "get",
 *     "post",
 *     "post_user"={
 *          "method"="POST",
 *          "path"="/register",
 *          "controller"="App\Controller\RegisterUser"
 *     },
 *  })
 * @ApiFilter(SearchFilter::class, properties={"givenName": "start", "lastName": "start"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * @var UuidInterface
     *
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=125)
     */
    private $givenName;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=125)
     */
    private $lastName;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=254)
     */
    private $phone;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $playerId;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=254)
     */
    private $email;

    /**
     * @Groups({ "read", "write"})
     * @var MediaObject|null
     * @ORM\OneToOne(targetEntity="MediaObject", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", nullable=true)
     */
    public $image;

    /**
     * @Groups({"write"})
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="author_id")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="UserEvent", mappedBy="user")
     */
    private $userEvents;

    /**
     * @ORM\OneToMany(targetEntity="Expense", mappedBy="user")
     */
    private $expenses;

    public function __construct()
    {
        $this->expenses = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->userEvents = new ArrayCollection();
    }

    /**
     * @return UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|UserEvent[]
     */
    public function getUsersEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addUserEvent(UserEvent $userEvent): self
    {
        if (!$this->userEvents->contains($userEvent)) {
            $this->userEvents[] = $userEvent;
            $userEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUserEvent(UserEvent $userEvent): self
    {
        if ($this->userEvents->contains($userEvent)) {
            $this->userEvents->removeElement($userEvent);
            if ($userEvent->getEvent() === $this) {
                $userEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserEvent[]
     */
    public function getEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserEvent[]
     */
    public function getExpenses(): Collection
    {
        return $this->userEvents;
    }

    public function addExpense(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeExpense(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): void
    {
        return;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string/null
     */
    public function getPlayerId(): ?string
    {
        return $this->playerId;
    }

    /**
     * @param string $playerId
     */
    public function setPlayerId(string $playerId): void
    {
        $this->playerId = $playerId;
    }
}
