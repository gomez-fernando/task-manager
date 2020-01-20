<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Form\RegisterType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // crear formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        // rellenar el objeto
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // modificando el objeto para guardarlo
            $user->setRole('ROLE_USER');
            // guardar la fecha de cratedAt
            $user->setCreatedAt(new \DateTime('now'));

            // cifrar la contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            // guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        // var_dump($user);

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}