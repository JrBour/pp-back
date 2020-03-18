<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $givenName;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=254)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Events", inversedBy="author_id")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UsersEvents", inversedBy="user_id")
     */
    private $usersEvents;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Expenses", inversedBy="user")
     */
    private $expenses;

    public function getId(): ?int
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
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

    public function getEvents(): ?Events
    {
        return $this->events;
    }

    public function setEvents(?Events $events): self
    {
        $this->events = $events;

        return $this;
    }

    public function getUsersEvents(): ?UsersEvents
    {
        return $this->usersEvents;
    }

    public function setUsersEvents(?UsersEvents $usersEvents): self
    {
        $this->usersEvents = $usersEvents;

        return $this;
    }

    public function getExpenses(): ?Expenses
    {
        return $this->expenses;
    }

    public function setExpenses(?Expenses $expenses): self
    {
        $this->expenses = $expenses;

        return $this;
    }
}
