<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        //////////////////----------------------------------
        //prueba de entidades y relaciones
        $em = $this->getDoctrine()->getManager();

        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        // $tasks = $task_repo->findAll();
        $tasks = $task_repo->findBy([], ['id' => 'DESC']);

        // foreach ($tasks as $task) {
        //     echo $task->getUser()->getName(). ' Tarea: ' . $task->getTitle() . '<br/>';
        // }
        //-----------------------------------------------------

        // otra prueba para sacar todos los usuarios y las tareas adjuntas
        // $user_repo = $this->getDoctrine()->getRepository(User::class);
        // $users = $user_repo->findAll();

        // foreach ($users as $user) {
        //     echo "<h1> {$user->getName()} {$user->getSurName()} </h1>";

        //     foreach ($user->getTasks() as $task) {
        //         echo $task->getUser()->getName(). ' Tarea: ' . $task->getTitle() . '<br/>';
        //     }
        // }

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    public function detail(Task $task)
    {
        if (!$task) {
            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }

    public function creation(Request $request, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // var_dump($task);
            $task->setCreatedAt(new \DateTime('now'));
            // var_dump($user);
            $task->setUser($user);
            // var_dump($task);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', [
                    'id' => $task->getId()
                ])
            );
        }

        return $this->render('task/creation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function myTasks(UserInterface $user)
    {
        $tasks = $user->getTasks();

        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function edit(Request $request, UserInterface $user, Task $task)
    {
        // dd($user->getId());
        if (!$user || $user->getId() != $task->getUser()->getId()) {
            return $this->redirectToRoute('tasks');
        }
        // var_dump($task);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // var_dump($task);
            // $task->setCreatedAt(new \DateTime('now'));
            // var_dump($user);
            // $task->setUser($user);
            // var_dump($task);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', [
                    'id' => $task->getId()
                ])
            );
        }


        return $this->render('task/creation.html.twig', [
            'edit' => true,
            'form' => $form->createView()
        ]);
    }

    public function delete(UserInterface $user, Task $task)
    {
        if (!$user || $user->getId() != $task->getUser()->getId()) {
            return $this->redirectToRoute('tasks');
        }

        if (!$task) {
            return $this->redirectToRoute('tasks');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('tasks');
    }
}