<?php
declare(strict_types=1);

namespace Application\Service;

use Domain\DTO\CardDTO;
use Infrastructure\Repository\CardRepository;
use Domain\Model\Card;
use Ramsey\Uuid\Uuid;

class CardService
{
    private CardRepository $repository;

    public function __construct(CardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CardDTO $cardDTO
     * @return Card
     * @throws \Infrastructure\Repository\RepositoryException
     */
    public function create(CardDTO $cardDTO): Card
    {
        $card = new Card(
            Uuid::uuid4()->toString(),
            $cardDTO->title
        );
        $this->repository->save($card);

        return $card;
    }
    /**
     * @param CardDTO $cardDTO
     * @return Card
     * @throws \Infrastructure\Repository\RepositoryException
     */
    public function update(Card $card, CardDTO $cardDTO): Card
    {
        if ($cardDTO->title !== null) {
            $card->changeTitle($cardDTO->title);
        }

        $this->repository->save($card);

        return $card;
    }
}