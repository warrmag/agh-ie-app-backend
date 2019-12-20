<?php
declare(strict_types=1);

namespace Domain\DTO;

use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\UuidInterface;

class TaskDTO
{
    /**
     * @Serializer\Type("string")
     */
    public ?string $title = null;

    /**
     * @Serializer\Type("int")
     */
    public ?int $position = null;

    /**
     * @Serializer\Type("bool")
     */
    public bool $isDone;
}
