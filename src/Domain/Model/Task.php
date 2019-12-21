<?php
declare(strict_types=1);

namespace Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\DTO\TaskDTO;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Infrastructure\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true, length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $title;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $position;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Serializer\SerializedName("done")
     */
    private bool $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="taskList")
     */
    private Card $card;

    public function __construct(string $id, string $title, int $position, Card $card)
    {
        $this->id = $id;
        $this->title = $title;
        $this->position = $position;
        $this->isDone = false;
        $this->addToCard($card);
    }

    public function updateFromData(TaskDTO $taskDTO): void
    {
        $this->title = $taskDTO->title ?? $this->title;
        $this->position = $taskDTO->position ?? $this->position;
        $this->isDone = $taskDTO->isDone ?? $this->isDone;
    }

    public function addToCard(Card $card): void
    {
        $card->addTask($this);
        $this->card = $card;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
