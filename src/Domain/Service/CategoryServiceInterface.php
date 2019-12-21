<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\DTO\CategoryDTO;
use Domain\Model\Category;

interface CategoryServiceInterface
{
    public function create(CategoryDTO $categoryDTO): Category;

    public function update(Category $category, CategoryDTO $categoryDTO): Category;
}
