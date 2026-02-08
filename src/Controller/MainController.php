<?php

namespace App\Controller;

use App\Dto\PersonInput;
use App\Dto\PersonModel;
use App\Service\AppFormDtoFactory;
use App\Service\AppFormSubmissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    public function __construct(private readonly AppFormSubmissionService $formService) {}

    #[Route('/', name: 'form_index', methods: ['GET'])]
    public function index(): Response
    {
        // renderuje widok Vue (assets/build/main.js)
        return $this->render('form.html.twig');
    }

    #[Route('/form', name: 'form_submit', methods: ['POST'])]
    public function submit(Request $request, AppFormDtoFactory $dtoFactory): JsonResponse
    {

        $dto = $dtoFactory->createPersonModelFromJson($request->getContent());

        $response = $this->formService->submitAppForm($dto);

        $statusCode = $response['success'] ? 200 : 400;


        return $this->json($response, $statusCode);
    }
}
