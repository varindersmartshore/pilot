<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Lists;
use App\Form\ItemsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ItemsController extends AbstractController
{
    /**
     * @Route("/items", name="items")
     */
    public function index(): Response
    {
        return $this->render('items/index.html.twig', [
            'controller_name' => 'ItemsController',
        ]);
    }

    // Display add item page and save data in database
    public function addItem($id, Request $request, EntityManagerInterface $entityManager)
    {
        $item = new Items();
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($id);
        $form = $this->createForm(ItemsFormType::class, $item, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $item->setListId($list);
            $entityManager->persist($item);
            $entityManager->flush();
            $this->addFlash('success', 'The item is added!');
            return $this->redirectToRoute('index');

        }
        return $this->render('items/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Display edit item page with specific id
    public function editItem(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $item = new Items();
        $item = $this->getDoctrine()->getRepository(Items::class)->find($id);
        $form = $this->createForm(ItemsFormType::class, $item, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $items = $form->getData();
            $entityManager->persist($items);
            $entityManager->flush();
            $this->addFlash('success', 'The item is updated!');
            return $this->redirectToRoute('index');
        }
        return $this->render('items/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Delete existing item
    public function deleteItem(Request $request, EntityManagerInterface $entityManager)
    {
        $method = $request->request->get('_method');
        $id = $request->request->get('id');
        $item = $this->getDoctrine()->getRepository(Items::class)->find($id);
        if (!empty($item) && $method == "DELETE") {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', 'The item has been deleted!');
            return $this->redirectToRoute('index');
        } else {
            $this->addFlash('failed', 'The item has not been deleted!');
            return $this->redirectToRoute('index');
        }
    }
}