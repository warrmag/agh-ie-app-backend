<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\Model\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category): void
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($category);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @param Category $category
     * @throws RepositoryException
     */
    public function flush()
    {
        try {
            $this->getEntityManager()->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function remove(Category $category): void
    {
        $em = $this->getEntityManager();

        try {
            $em->remove($category);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
