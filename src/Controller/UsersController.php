<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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

    // Display add user page
    public function addUser()
    {
        return $this->render('users/add.html.twig');
    } 

    // Insert new user in DB
    public function insertUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $users = new Users;
        $errors = $validator->validate($users);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        } else {
            $submittedToken = $request->request->get('_csrf_token');
            if ($this->isCsrfTokenValid('authenticate_add_user', $submittedToken)) {
                $users->setUsername($request->request->get('username'));
                $users->setPassword($request->request->get('password'));
                $users->setEmail($request->request->get('email'));
                $users->setStatus(1);
                $entityManager->persist($users);
                $entityManager->flush();
                $this->addFlash('success', 'The user is added!');
                return $this->redirectToRoute('users');
            } else {
                return new Response('Invalid Token!');
            }
        }
        return new Response('Something went wrong!');
    }

    // Display edit user page with specific id
    public function editUser(int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy([
            'id' => $id,
        ]);
        return $this->render('users/edit.html.twig',[
            'user' => $user
        ]);
    } 

    // Update an existing user
    public function updateUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $users = new Users;
        $errors = $validator->validate($users);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        } else {
            $submittedToken = $request->request->get('_csrf_token');
            if ($this->isCsrfTokenValid('authenticate_edit_user', $submittedToken)) {
                $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['id'=>$request->request->get('id')]);
                $user->setUsername($request->request->get('username'));
                $user->setEmail($request->request->get('email'));
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'The user is updated!');
                return $this->redirectToRoute('users');
            } else {
                return new Response('Invalid Token!');
            }
        }
        return new Response('Something went wrong!');
    }
    
    // Delete existing user
    public function deleteUser(int $id, EntityManagerInterface $entityManager)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy([
            'id' => $id,
        ]);
        if (!empty($user)) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'The user is deleted!');
            return $this->redirectToRoute('users');
        } else {
            $this->addFlash('failed', 'The user not found!');
            return $this->redirectToRoute('users');
        }
    }
}
