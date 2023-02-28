<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Session;
use App\Game\Adventure;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdventureController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SessionRepository $sessionRepository
    ) {
    }

    #[Route('/adventure/start', name: 'app_adventure_start', methods: ['POST'])]
    public function index(): JsonResponse
    {
        $adventure = Adventure::start();
        $session   = (new Session())->setState($adventure->state());
        $this->em->persist($session);
        $this->em->flush();

        return $this->json($session);
    }

    #[Route('/adventure/{id}', name: 'app_adventure_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $session = $this->sessionRepository->find($id);

        return $this->json($session);
    }
}
