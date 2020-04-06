<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUser extends AbstractController
{
    private $em;

    private $encoder;

    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, FileUploader $fileUploader)
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
        $this->fileUploader = $fileUploader;
    }

    public function __invoke(User $data)
    {
        $user = new User();
        $user->setGivenName($data->getGivenName());
        $user->setLastName($data->getLastName());
        $user->setPhone($data->getPhone());
        $user->setEmail($data->getEmail());
        $user->setPassword($this->encoder->encodePassword($user, $data->getPassword()));

        if ($data->getImage()){
            $imageName = $this->fileUploader->upload($data->getImage());
            $user->setImage($imageName);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }
}