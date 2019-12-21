<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\DTO\TaskDTO;
use Domain\Model\Card;
use Domain\Model\Task;

interface TaskServiceInterface
{
    public function create(Card $card, TaskDTO $taskDTO): Task;

    public function update(Task $task, TaskDTO $taskDTO): Task;
}
