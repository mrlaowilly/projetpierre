<?php


namespace App\Controller;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use App\Repository\BoardGameRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function show(BoardGame $boardGame, ValidatorInterface $validator)
    {
        // pas utile ici juste pour un exemple de validation hors formulaire
        $errors = $validator->validate($boardGame);
        return $this->render("board_game/show.html.twig", [
            'board_game' => $boardGame,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $game = new BoardGame();

        $form = $this->createForm(BoardGameType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($game);
            $manager->flush();

            $this->addFlash('success', 'Nouveau jeu crée');
            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('board_game/new.html.twig', [
            'new_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     */
    public function edit(BoardGame $game, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(BoardGameType::class, $game, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'mis a jour');
            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('board_game/edit.html.twig', [
            'game' => $game,
            'edit_form' => $form->createView(),
        ]);
    }
}