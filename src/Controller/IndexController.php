<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        $your_name = "Welcome!";
        return $this->render('index.html.twig', [
            'your_name' => $your_name,
        ]);
    }
}
?>