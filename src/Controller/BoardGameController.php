<?php


namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
     * Composant ParamConverter est capable de traduire un parametre de route en :
     * - entité
     * \DateTime
     */
    public function show(BoardGame $boardGame)
    {
        return $this->render("board_game/show.html.twig", [
            'board_game' => $boardGame,
        ]);
    }

    /**
     * @Route("/new")
     */
    public function new()
    {
        $game = new BoardGame();

        $form = $this->createFormBuilder($game)
            ->add('name', null, [
                'label' => 'nom',
            ])
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('releasedAt', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de sortie',
            ])
            ->add('ageGroup', null, [
                'label' => 'A partir de',
            ])
            ->getForm();

        return $this->render('board_game/new.html.twig', [
            'new_form' => $form->createView(),
        ]);
    }
}