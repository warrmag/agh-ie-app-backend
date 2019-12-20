<?php
declare(strict_types=1);

namespace UI\Controller;

use Domain\DTO\TaskDTO;
use Domain\Model\Card;
use Domain\Model\Task;
use Infrastructure\Repository\RepositoryException;
use Application\Service\TaskService;
use Infrastructure\Repository\TaskRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private SerializerInterface $serializer;

    private TaskService $taskService;

    private TaskRepository $taskRepository;

    public function __construct(SerializerInterface $serializer, TaskService $taskService, TaskRepository $taskRepository)
    {
        $this->serializer = $serializer;
        $this->taskService = $taskService;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/cards/{id}/tasks", name="create_task", methods={"POST"})
     * @param Card $card
     * @param Request $request
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function create(Card $card, Request $request): Response
    {
        $taskDTO = $this->serializer->deserialize($request->getContent(), TaskDTO::class,'json');
        $task = $this->taskService->create($card, $taskDTO);

        return new Response($this->serializer->serialize($task, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/cards/{id}", name="get_task", methods={"GET"})
     * @param Card $card
     * @return JsonResponse
     */
    public function findOne(Card $card): Response
    {
        return new Response($this->serializer->serialize($card, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/tasks/{id}", name="update", methods={"PUT"})
     * @param Task $task
     * @param Request $request
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function update(Task $task, Request $request): Response
    {
        $taskDTO = $this->serializer->deserialize($request->getContent(), TaskDTO::class,'json');
        $task = $this->taskService->update($task, $taskDTO);

        return new Response($this->serializer->serialize($task, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/tasks/{id}", name="delete", methods={"DELETE"})
     * @param Task $task
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function delete(Task $task): Response
    {
        $this->taskRepository->remove($task);

        return new JsonResponse(
            [
                'message' => 'Task deleted!'
            ],
            Response::HTTP_OK
        );
    }
}
