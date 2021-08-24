<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AddUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

class UsersController extends AbstractController
{
    // Display list of users
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findBy([
            'status' => 1,
        ]);
        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }

    // Display add user page and save data in database
    public function addUser(Request $request, EntityManagerInterface $entityManager)
    {
        $user = new Users();
        $form = $this->createForm(AddUserFormType::class, $user, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $users = $form->getData();
            $users->setStatus(1);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'The user is added!');
            return $this->redirectToRoute('users');

        }
        return $this->render('users/add.html.twig', [
            'form' => $form->createView(),
        ]);
    } 

    // Display edit user page with specific id
    public function editUser(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $user = new Users();
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        $form = $this->createForm(AddUserFormType::class, $user, [
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $users = $form->getData();
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'The user is updated!');
            return $this->redirectToRoute('users');
        }
        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    } 
    
    // Delete existing user
    public function deleteUser(int $id, EntityManagerInterface $entityManager)
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        if (!empty($user)) {
            $entityManager->remove($user);
            $entityManager->flush();
            $response = new Response();
            $response->send();
        } else {
            $this->addFlash('failed', 'The user not found!');
            return $this->redirectToRoute('users');
        }
    }
}
