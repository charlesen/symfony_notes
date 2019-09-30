<?php
// src/Controller/NoteController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class NoteController
{
    public function index()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Note: '.$number.'</body></html>'
        );
    }
}
