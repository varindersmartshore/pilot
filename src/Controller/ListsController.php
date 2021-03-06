<?php

namespace App\Controller;

use App\Entity\Lists;
use App\Form\ListsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Routing\Exception\NoConfigurationException;

class ListsController extends AbstractController
{
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;        
    }

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
            $translated = $this->translator->trans('list.add');
            $this->addFlash('success', $translated);
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
                //$lists = $form->getData();
                $entityManager->persist($list);
                $entityManager->flush();
                $translated = $this->translator->trans('list.update');
                $this->addFlash('success', $translated);
                return $this->redirectToRoute('index');
            }
            return $this->render('lists/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            throw $this->createNotFoundException($this->translator->trans('list.valid'), new NoConfigurationException());
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
            $translated = $this->translator->trans('list.delete');
            $this->addFlash('success', $translated);
            return $this->redirectToRoute('index');
        } else {
            $translated = $this->translator->trans('list.notdelete');
            $this->addFlash('failed', $translated);
            return $this->redirectToRoute('index');
        }  
    }

    private function getData(): array
    {
        /**
         * @var $list Lists[]
         */
        $getList = [];
        $lists = $this->getDoctrine()->getRepository(Lists::class)->findAll();

        foreach ($lists as $list) {
            $getList[] = [
                $list->getId(),
                $list->getListName()
            ];
        }
        return $getList;
    }

    /**
     * @Route("/export",  name="export")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('List');

        $sheet->getCell('A1')->setValue('ID');
        $sheet->getCell('B1')->setValue('List Name');

        // Increase row cursor after header write
        $sheet->fromArray($this->getData(),null, 'A2', true);
        $filePath = 'lists.xlxs';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $this->redirectToRoute('index');
    }
}
