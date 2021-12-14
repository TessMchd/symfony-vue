<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @ApiResource()
 * @Route("/api/functions")
 */
class Recherche extends AbstractController
{
    /**
     * @Route ("/recherche/{recherche}", name="recherche")
     */
    public function recherche (
        MessageRepository $messageRepository,
        CategoryRepository $categoryRepository,
        SerializerInterface $serializer,
        string $recherche
    ) {
        $messages = $serializer->serialize($messageRepository->search($recherche), 'json', ['groups' => 'list-message']);
        $categories = $serializer->serialize($categoryRepository->search($recherche), 'json', ['groups' => 'messages']) ;
        $response = [
            'messages' => $messages,
            'categories' => $categories
        ];
        return new Response($serializer->serialize($response, 'json'));
    }

}