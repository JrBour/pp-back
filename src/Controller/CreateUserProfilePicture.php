<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateUserProfilePicture extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function __invoke(Request $request, $id)
    {
        $uploadedFile = $request->files->get('file');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        $user = $this->em->getRepository(User::class)->find($id);

        if(!$user){
            throw new \Exception(sprintf('User with ID "%d" not found', $id));
        }
        $user->setImage($mediaObject);

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }
}
