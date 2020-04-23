<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampableEntity;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *      denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ApiFilter(DateFilter::class, properties={"startAt", "endAt"})
 * @ApiFilter(SearchFilter::class, properties={"userEvents.user.id": "exact", "userEvents.status": "exact", "author.id": "exact"})
 * @ORM\Table(name="events")
 */
class Event
{
    use TimestampableEntity;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=90)
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Groups({ "read", "write"})
     * @var MediaObject|null
     * @ORM\OneToOne(targetEntity="MediaObject", inversedBy="event", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", nullable=true)
     */
    public $image;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=125)
     */
    private $city;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $zipcode;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     */
    private $shareFees;

    /**
     * @Groups({"read"})
     * @ORM\OneToMany(targetEntity="UserEvent", mappedBy="event", cascade={"persist", "remove"})
     */
    private $userEvents;

    /**
     * @Groups({"read"})
     * @ORM\OneToMany(targetEntity="Expense", mappedBy="event")
     */
    private $expenses;

    /**
     * @Groups({"read", "write"})
     * @ORM\OneToOne(targetEntity="App\Entity\Album", mappedBy="event", cascade={"persist", "remove"})
     */
    private $album;

    public function __construct()
    {
        $this->userEvents = new ArrayCollection();
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

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getShareFees(): ?bool
    {
        return $this->shareFees;
    }

    public function setShareFees(bool $shareFees): self
    {
        $this->shareFees = $shareFees;

        return $this;
    }

    /**
     * @return Collection|UserEvent[]
     */
    public function getUserEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addUserEvents(UserEvent $userEvent): self
    {
        if (!$this->userEvents->contains($userEvent)) {
            $this->userEvents[] = $userEvent;
            $userEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUserEvents(UserEvent $userEvent): self
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
     * @return Collection|Expense[]
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->setEvent($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->contains($expense)) {
            $this->expenses->removeElement($expense);
            if ($expense->getEvent() === $this) {
                $expense->setEvent(null);
            }
        }

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        // set the owning side of the relation if necessary
        if ($album->getEvent() !== $this) {
            $album->setEvent($this);
        }

        return $this;
    }
}
