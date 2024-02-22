<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{


    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, ActorRepository $actorRepository): Response
    {
        $actor = $actorRepository->findOneBy(['id' => $id]);

        if (!$actor) {
            throw $this->createNotFoundException(
                'No actor with id : ' . $id . ' found'
            );
        } else {
            return $this->render('actor/show.html.twig', [
                'actor' => $actor
            ]);
        }

    }
}


