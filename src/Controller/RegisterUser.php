<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUser extends AbstractController
{
    private $em;

    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
    }

    public function __invoke(User $data)
    {
        $user = new User();
        $user->setGivenName($data->getGivenName());
        $user->setLastName($data->getLastName());
        $user->setPhone($data->getPhone());
        $user->setEmail($data->getEmail());
        $user->setPassword($this->encoder->encodePassword($user, $data->getPassword()));

        if ($data->getImage()) {
            $mediaObject = $this->em->getRepository(MediaObject::class)->find($data->getImage());
            $user->setImage($mediaObject);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }
}
