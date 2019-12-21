<?php
declare(strict_types=1);

namespace Application\Service;


use Domain\Model\Card;
use Domain\Service\CategoryServiceInterface;
use Domain\DTO\CategoryDTO;
use Domain\Model\Category;
use Infrastructure\Repository\CategoryRepository;
use Ramsey\Uuid\Uuid;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CategoryDTO $categoryDTO): Category
    {
        $category = new Category(
            Uuid::uuid4()->toString(),
            $categoryDTO->title()
        );

        $this->categoryRepository->save($category);

        return $category;
    }

    public function addCard(Category $category, Card $card): Category
    {
        $card->addToCategory($category);

        $this->categoryRepository->flush();

        return $category;
    }

    public function update(Category $category, CategoryDTO $categoryDTO): Category
    {
        // TODO: Implement update() method.
    }
}
