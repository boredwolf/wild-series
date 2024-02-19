<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->find($id);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }

    #[Route('/{id}/season/{seasonId}', name: 'season_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showSeason(int $id, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->find($id);
        $season = $seasonRepository->find($seasonId);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found'
            );
        }

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id' . $seasonId . ' found'
            );
        }

        return $this->render('program/show_season.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

}

