<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *      denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 * )
 * @ApiFilter(SearchFilter::class, properties={"event.userEvents.user.id": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 * @ORM\Table(name="albums")
 */
class Album
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\OneToOne(targetEntity="App\Entity\Event", inversedBy="album", cascade={"persist", "remove"})
     */
    private $event;

    /**
     * @Groups({"read"})
     * @ORM\OneToMany(targetEntity="AlbumMedia", mappedBy="album")
     */
    private $medias;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection|AlbumMedia[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(AlbumMedia $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setAlbum($this);
        }

        return $this;
    }

    public function removeMedia(AlbumMedia $media): self
    {
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
            if ($media->getAlbum() === $this) {
                $media->setAlbum(null);
            }
        }

        return $this;
    }

}
