<?php
declare(strict_types=1);

namespace Application\Service;

use Domain\Service\TaskServiceInterface;
use Domain\DTO\TaskDTO;
use Domain\Model\Card;
use Infrastructure\Repository\RepositoryException;
use Infrastructure\Repository\TaskRepository;
use Domain\Model\Task;
use Ramsey\Uuid\Uuid;

class TaskService implements TaskServiceInterface
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TaskDTO $taskDTO
     * @return Task
     * @throws RepositoryException
     */
    public function create(Card $card, TaskDTO $taskDTO): Task
    {
        $task = new Task(
            Uuid::uuid4()->toString(),
            $taskDTO->title,
            $taskDTO->position ?? 0,
            $card
        );
        $this->repository->save($task);

        return $task;
    }

    /**
     * @param TaskDTO $taskDTO
     * @return Task
     * @throws RepositoryException
     */
    public function update(Task $task, TaskDTO $taskDTO): Task
    {
        $task->updateFromData($taskDTO);
        $this->repository->save($task);

        return $task;
    }
}
