<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api", name="api")
 */

class ApiController extends AbstractController
{
    /**
     * @var TaskRepository
     */

    private $taskRepository;

    public function __construct(TaskRepository $taskRepository){
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/tasks", name="api_get_tasks", methods={"GET"})
     * @return Response
     */

    public function getTasks() {
        $tasks = $this->taskRepository->findAll();
        return $this->json($tasks);
    }

    /**
     * @Route("/tasks/{taskId}", name="api_get_task", methods={"GET"})
     * @param int $taskId
     * @return Response
     */

    public function getTask(int $taskId) {
        $task = $this->taskRepository->find($taskId);

        return $this->json($task);
    }
    /**
     * @Route("/tasks/{taskId}", name="api_delete_task", methods={"DELETE"})
     * @param int $taskId
     * @return Response
     */
    public function deleteTask(int $taskId): Response {
        $task = $this->taskRepository->find($taskId);
        if(!$task instanceof Task) {
            throw new NotFoundHttpException();
        }
        $this->taskRepository->delete($task);
        return $this->json("Task delete succesfully");
    }

    /**
     * @Route("/tasks", name="api_post_task", methods={"POST"})
     * @param Request $request
     * @return Response
     */

    public function postTask(Request $request): Response {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->submit($request->request->all());
        $this->taskRepository->save($task);
        return $this->json("Task succesfully add");
    }
}
