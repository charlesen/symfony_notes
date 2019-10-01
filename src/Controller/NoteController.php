<?php
// src/Controller/NoteController.php
namespace App\Controller;

use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//  php bin/console make:migration
//  php bin/console doctrine:migrations:migrate
//  php bin/console doctrine:query:sql 'SELECT * FROM note'

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
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        if (!$note) {
            throw $this->createNotFoundException("Aucun item trouvé avec l'id ".$id);
        }
        return $this->render('note/show.html.twig', [
          'id' => $id,
          'title' => $note->getTitle(),
          'content' => $note->getContent(),
          'number' => random_int(0, 100),
      ]);
    }

    // /**
    //  * @Route("/note/{id}", name="note_show")
    //  */
    // public function edit(int $id)
    // {
    //     return $this->render('note/edit.html.twig', [
    //       'id' => $id,
    //       'number' => random_int(0, 100),
    //   ]);
    // }


    /**
     * @Route("/create", name="note_create")
     */
    public function create(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();
        $note = new Note();

        $number = random_int(0, 100);
        $note->setTitle('Une note '.$number);
        $note->setContent('Je suis une note'.$number);

        // tell Doctrine you want to (eventually) save the Item (no queries yet)
        $entityManager->persist($note);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response(" Nouvelle note créée n°".$note->getId());
    }
}
