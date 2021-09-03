<?php

namespace App\Controller;

use App\Entity\Lists;
use App\Form\ListsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListsController extends AbstractController
{
    /**
     * @Route("/lists", name="lists")
     */
    public function index(): Response
    {
        return $this->render('lists/index.html.twig', [
            'controller_name' => 'ListsController',
        ]);
    }

    // Display add list page and save data in database
    public function addList(Request $request, EntityManagerInterface $entityManager)
    {
        $list = new Lists();
        $form = $this->createForm(ListsFormType::class, $list, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $list = $form->getData();
            $list->setUser($this->getUser());
            $entityManager->persist($list);
            $entityManager->flush();
            $this->addFlash('success', 'The list is added!');
            return $this->redirectToRoute('index');
        }
        return $this->render('lists/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Display edit list page with specific id
    public function editList(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $list = new Lists();
        $list = $this->getDoctrine()->getRepository(Lists::class)->findOneBy([
            'id' => $id,
            'user' => $this->getUser(),
        ]);
        if(!empty($list)){
            $form = $this->createForm(ListsFormType::class, $list, [
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $lists = $form->getData();
                $entityManager->persist($lists);
                $entityManager->flush();
                $this->addFlash('success', 'The list is updated!');
                return $this->redirectToRoute('index');
            }
            return $this->render('lists/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('failed', 'Please select valid item!');
            return $this->redirectToRoute('index');
        }
    }

    // Delete existing list
    public function deleteList(Request $request, EntityManagerInterface $entityManager)
    {
        $method = $request->request->get('_method');
        $id = $request->request->get('id');
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($id);
        if (!empty($list) && $method == "DELETE") {
            $entityManager->remove($list);
            $entityManager->flush();
            $this->addFlash('success', 'The list has been deleted!');
            return $this->redirectToRoute('index');
        } else {
            $this->addFlash('failed', 'The list has not been deleted!');
            return $this->redirectToRoute('index');
        }
    }
}
