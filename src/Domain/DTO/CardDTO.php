<?php
declare(strict_types=1);

namespace Domain\DTO;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;

class CardDTO
{
    /**
     * @Serializer\Type("string")
     */
    public ?string $title = null;

    /**
     * @Serializer\Type("ArrayCollection<Task>")
     */
    public Collection $task;
}
