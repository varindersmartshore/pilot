<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordHashInterface,MailerInterface $mailer): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordHashInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $verification_token = rand();
            $user->setVerificationToken($verification_token);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $email = (new TemplatedEmail())
            ->from('varinder@smartshore.nl')
            ->to($user->getEmail())
            ->subject('Please confirm your email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
            ->context([
                'expiration_date' => new \DateTime('+1 hour'),
                'username' => $user->getEmail(),
                'path' => $this->generateUrl('app_verify_email', ['email' => base64_encode($user->getEmail()), 'token' => base64_encode($verification_token)], UrlGeneratorInterface::ABSOLUTE_URL)
            ])
            ;
            $mailer->send($email);

            $this->addFlash('success', 'Confirmation link sent to your email.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email/{email}/{token}", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request,$email,$token, EntityManagerInterface $entityManager): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findOneBy([
            'email' => base64_decode($email),
            'verification_token' => base64_decode($token)
        ]);
        if(!empty($users)) {
            $users->setIsVerified(true);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'Your email address has been verified.');
            return $this->redirectToRoute('app_login');
        } else {
            $this->addFlash('error', 'Your link is not valid.');
            return $this->redirectToRoute('app_register');
        }
    }
}
