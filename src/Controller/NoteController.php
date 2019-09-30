<?php
// src/Controller/NoteController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{
    /**
       * Note list
       ** @Route("/note", name="note_index")
       */
    public function index()
    {
        return $this->render('note/index.html.twig', [
            'number' => random_int(0, 100),
        ]);
    }

    /**
     * @Route("/note/{id}", name="note_show")
     */
    public function show(int $id)
    {
        return $this->render('note/show.html.twig', [
          'id' => $id,
          'number' => random_int(0, 100),
      ]);
    }

    /**
     * @Route("/note/{id}", name="note_show")
     */
    public function edit(int $id)
    {
        return $this->render('note/edit.html.twig', [
          'id' => $id,
          'number' => random_int(0, 100),
      ]);
    }
}
