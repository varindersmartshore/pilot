<?php
// src/Controller/IndexController.php
namespace App\Controller;

use App\Entity\Lists;
use App\Service\ItemSort;
use App\Entity\Items;
use App\Form\ItemsFormType;
use App\Form\DeleteItemFormType;
use App\Form\ListsFormType;
use App\Repository\ListsRepository;
use App\Repository\ItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index(ItemSort $ItemSort)
    {
        if ($this->getUser()) {
            $lists = $this->getDoctrine()
                    ->getRepository(Lists::class)
                    ->findBy(['user' => $this->getUser()->getId()]);
            foreach($lists as $key => $list)
            {
                $lists[$key]->sortedItems = $ItemSort->sortByOrder($list) ;
            }
            return $this->render('index.html.twig', [
                'lists' => $lists,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
?>