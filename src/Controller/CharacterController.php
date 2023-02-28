<?php

declare(strict_types=1);

namespace App\Controller;

use App\Game\Adventure;
use App\Game\Exception\CouldNotAttack;
use App\Game\Exception\CouldNotMove;
use App\Game\RollerInterface;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SessionRepository $sessionRepository,
        private RollerInterface $roller
    ) {
    }

    #[Route('/character/{id}/action/move', name: 'app_character_move', methods: ['POST'])]
    public function move(int $id): JsonResponse
    {
        $session   = $this->sessionRepository->find($id);
        $adventure = Adventure::fromState($session->getState());

        try {
            $adventure->move($this->roller);

            $session->setState($adventure->state());
            $this->em->persist($session);
            $this->em->flush();

            return $this->json($session);
        } catch (CouldNotMove $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
    }

    #[Route('/character/{id}/action/attack', name: 'app_character_attack', methods: ['POST'])]
    public function attack(int $id): JsonResponse
    {
        $session   = $this->sessionRepository->find($id);
        $adventure = Adventure::fromState($session->getState());

        try {
            $adventure->attack($this->roller);

            $session->setState($adventure->state());
            $this->em->persist($session);
            $this->em->flush();

            return $this->json($session);
        } catch (CouldNotAttack $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
    }
}
