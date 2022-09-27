<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoiffureRepository;
use Symfony\Component\Serializer\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ApiController extends AbstractController
{
    #[Route('/api/coiffure', name: 'api_coiffure', methods: ['GET'])]
    public function index(CoiffureRepository $coiffureRepository): Response
    {

        return $this->json($coiffureRepository->findAll(), 200, [], ['groups' => 'coiffure:read']);

    }

    public function store(Request $request)
    {
    $json = $request->getContent();
    
}
}
