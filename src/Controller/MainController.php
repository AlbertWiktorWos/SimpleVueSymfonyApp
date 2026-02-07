<?php

namespace App\Controller;

use App\Service\FormSubmissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(private readonly FormSubmissionService $formService) {}

    #[Route('/', name: 'form_index', methods: ['GET'])]
    public function index(): Response
    {
        // renderuje widok Vue (assets/build/main.js)
        return $this->render('form/index.html.twig');
    }

    #[Route('/form', name: 'form_submit', methods: ['POST'])]
    public function submit(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $response = $this->formService->submitForm($data);

        $statusCode = $response['success'] ? 200 : 400;

        return $this->json($response, $statusCode);
    }
}
