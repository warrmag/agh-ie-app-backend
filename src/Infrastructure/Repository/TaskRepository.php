<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Domain\Model\Task;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param Task $task
     * @throws RepositoryException
     */
    public function save(Task $task): void
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($task);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode());
        }
    }

    public function remove(Task $task): void
    {
        $em = $this->getEntityManager();

        try {
            $em->remove($task);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
