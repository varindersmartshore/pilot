<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController extends AbstractController
{
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

    public function addUser()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findBy([
            'status' => 1,
        ]);
        return $this->render('users/add.html.twig');
    } 

    public function insertUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $users = new Users;
        $errors = $validator->validate($users);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        } else {
            $users->setUsername($request->request->get('username'));
            $users->setPassword($request->request->get('password'));
            $users->setEmail($request->request->get('email'));
            $users->setStatus(1);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'The user is added!');
            return $this->redirectToRoute('users');
        }
        return new Response('Something went wrong!');
    }

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

    public function updateUser(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $users = new Users;
        $errors = $validator->validate($users);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        } else {
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['id'=>$request->request->get('id')]);
            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'The user is updated!');
            return $this->redirectToRoute('users');
        }
        return new Response('Something went wrong!');
    }
    
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
            $this->addFlash('failed', 'The user is not deleted!');
            return $this->redirectToRoute('users');
        }
        
        
    }
}
