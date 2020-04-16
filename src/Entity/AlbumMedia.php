<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AlbumMediaRepository")
 * @ORM\Table(name="album_medias")
 */
class AlbumMedia
{
    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"write", "read"})
     * @ORM\OneToOne(targetEntity="MediaObject")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;

    /**
     * @Groups({"write", "read"})
     * @ORM\ManyToOne(targetEntity="Album")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private $album;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMedia(): ?MediaObject
    {
        return $this->media;
    }

    /**
     * @param MediaObject $media
     * @return mixed
     */
    public function setMedia(MediaObject $media): void
    {
        $this->media = $media;
    }

    /**
     * @return mixed
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    /**
     * @param mixed $album
     */
    public function setAlbum(Album $album): void
    {
        $this->album = $album;
    }
}
