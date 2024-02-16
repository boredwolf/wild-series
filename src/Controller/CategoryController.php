<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig',
            ['categories' => $categories]
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $id]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with id : ' . $id . ' found'
            );
        } else {
            $programs = $programRepository->findBy(['category' => $category], orderBy: ['id' => 'DESC'], limit: 3);
            return $this->render('category/show.html.twig', [
                'programs' => $programs
            ]);
        }

    }
}

