<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        //////////////////----------------------------------
        //prueba de entidades y relaciones
        // $em = $this->getDoctrine()->getManager();

        // $task_repo = $this->getDoctrine()->getRepository(Task::class);
        // $tasks = $task_repo->findAll();

        // foreach ($tasks as $task) {
        //     echo $task->getUser()->getName(). ' Tarea: ' . $task->getTitle() . '<br/>';
        // }
        //-----------------------------------------------------

        // otra prueba para sacar todos los usuarios y las tareas adjuntas
        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findAll();

        foreach ($users as $user) {
            echo "<h1> {$user->getName()} {$user->getSurName()} </h1>";

            foreach ($user->getTasks() as $task) {
                echo $task->getUser()->getName(). ' Tarea: ' . $task->getTitle() . '<br/>';
            }
        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}