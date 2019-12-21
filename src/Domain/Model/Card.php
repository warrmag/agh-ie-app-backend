<?php
declare(strict_types=1);

namespace Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity()
 */
class Card
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
     * @ORM\OneToMany(targetEntity="Task", mappedBy="card", cascade={"persist", "remove"})
     * @Serializer\SerializedName("elements")
     */
    private Collection $taskList;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="cardList")
     */
    private Category $category;

    /**
     * Card constructor.
     * @param string $id
     * @param string $title
     * @param Category $category
     * @param Collection $taskList
     */
    public function __construct(string $id, string $title, Category $category, Collection $taskList = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->taskList = $taskList ?? new ArrayCollection();
        $this->category = $category;
    }

    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param Task $task
     * @throws \Exception
     */
    public function addTask(Task $task): void
    {
        if ($this->taskList->contains($task)) {
            throw new \Exception('This card already contains this task');
        }

        $this->taskList->add($task);
    }

    public function addToCategory(Category $category): void
    {
        $this->category = $category;
        $category->addCard($this);
    }
}
