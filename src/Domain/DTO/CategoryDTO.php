<?php
declare(strict_types=1);

namespace Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class CategoryDTO
{
    /**
     * @Serializer\Type("string")
     */
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function title(): string
    {
        return $this->title;
    }
}
