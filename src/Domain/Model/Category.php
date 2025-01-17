<?php
declare(strict_types=1);

namespace Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="Infrastructure\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @Serializer\Groups({"list"})
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true, length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private string $id;

    /**
     * @Serializer\Groups({"list"})
     * @ORM\Column(type="string", nullable=false)
     */
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity="Card", mappedBy="category", cascade={"persist", "remove"})
     */
    private Collection $cardList;

    public function __construct(string $id, string $title, Collection $cardList = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->cardList = $cardList ?? new ArrayCollection();
    }

    public function addCard(Card $card): void
    {
        if ($this->cardList->contains($card)) {
            throw new \Exception('Card already exists in category');
        }

        $this->cardList->add($card);
    }
}
