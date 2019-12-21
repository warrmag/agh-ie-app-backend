<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\DTO\CardDTO;
use Domain\Model\Card;
use Domain\Model\Category;

interface CardServiceInterface
{
    public function create(CardDTO $categoryDTO, Category $category): Card;

    public function update(Card $card, CardDTO $categoryDTO): Card;
}
