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
use Symfony\Contracts\Translation\TranslatorInterface;

class ItemsController extends AbstractController
{
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;        
    }
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
        if(!empty($list)){
            $form = $this->createForm(ItemsFormType::class, $item, [
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $getOrder = $form->getData()->getOrderBy();
                $getMinMaxOrder = $this->getDoctrine()->getRepository(Items::class)->findOneByListIdGetMinMaxOrderBy($list);
                if($getOrder == 'top') {
                    $item->setOrderBy($getMinMaxOrder['min_order_by'] - 1);
                }else if($getOrder == 'bottom') {
                    $item->setOrderBy($getMinMaxOrder['max_order_by'] + 1);
                } else {
                    $item->setOrderBy($getMinMaxOrder['max_order_by']);
                }
                $item->setListId($list);
                $entityManager->persist($item);
                $entityManager->flush();
                $translated = $this->translator->trans('item.add');
                $this->addFlash('success', $translated);
                return $this->redirectToRoute('index');

            }
            return $this->render('items/add.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            $translated = $this->translator->trans('list.valid');
            $this->addFlash('failed', $translated);
            return $this->redirectToRoute('index');
        }
    }

    // Display edit item page with specific id
    public function editItem(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $item = new Items();
        $item = $this->getDoctrine()->getRepository(Items::class)->find($id);
        if(!empty($item)){
            $form = $this->createForm(ItemsFormType::class, $item, [
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $items = $form->getData();
                $entityManager->persist($items);
                $entityManager->flush();
                $translated = $this->translator->trans('item.update');
                $this->addFlash('success', $translated);
                return $this->redirectToRoute('index');
            }
            return $this->render('items/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            $translated = $this->translator->trans('item.valid');
            $this->addFlash('failed', $translated);
            return $this->redirectToRoute('index');
        }
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
            $translated = $this->translator->trans('item.delete');
            $this->addFlash('success', $translated);
            return $this->redirectToRoute('index');
        } else {
            $translated = $this->translator->trans('item.notdelete');
            $this->addFlash('failed', $translated);
            return $this->redirectToRoute('index');
        }
    }
}
