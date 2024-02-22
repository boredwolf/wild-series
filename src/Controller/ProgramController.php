<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Service\ProgramDuration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig',
            ['programs' => $programs],
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));


            $mailer->send($email);
            $this->addFlash('success', 'La nouvelle série a été crée !');
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'formView' => $form,
        ]);

    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program)
        ]);
    }

    #[Route('/{program}/season/{season}', name: 'season_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showSeason(Season $season, Program $program): Response
    {
        return $this->render('program/show_season.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

    #[Route('/{programSlug}/season/{seasonId}/episode/{episodeSlug}', name: 'episode_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEpisode(
        #[MapEntity(mapping: ['programSlug' => 'slug'])] Program $program,
        #[MapEntity(mapping: ['seasonId' => 'id'])] Season       $season,
        #[MapEntity(mapping: ['episodeSlug' => 'slug'])] Episode $episode,
    ): Response
    {
        return $this->render('program/show_episode.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }

}



