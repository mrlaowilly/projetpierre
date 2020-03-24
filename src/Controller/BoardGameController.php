<?php


namespace App\Controller;

use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("", methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findBy(['ageGroup' => 10]);
        $boardGames = $repository->findAll();

        return $this->render("board_game/index.html.twig", [
            'board_games' => $boardGames,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function show(int $id, BoardGameRepository $repository)
    {
        $boardGame = $repository->find($id);

        if (!$boardGame) {
            throw $this->createNotFoundException('Ce jeu n\'existe pas');
        }

        return $this->render("board_game/show.html.twig", [
            'board_game' => $boardGame,
        ]);
    }
}