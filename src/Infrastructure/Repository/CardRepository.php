<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Domain\Model\Card;
use Infrastructure\Repository\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function save(Card $card): void
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($card);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    public function remove(Card $card): void
    {
        $em = $this->getEntityManager();

        try {
            $em->remove($card);
            $em->flush();
        } catch (ORMException $exception) {
            throw new RepositoryException($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
