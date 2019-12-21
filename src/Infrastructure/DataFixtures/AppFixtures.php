<?php

namespace Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Model\Card;
use Domain\Model\Category;
use Domain\Model\Task;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    const DATA = [
        'Work' => [
            [
                'title' => 'This week',
                'taskList' => [
                    [
                        'title' => 'Tell Mark to log work',
                        'position' => 1
                    ],
                    [
                        'title' => 'Ask Judy about last week report',
                        'position' => 2
                    ],
                    [
                        'title' => 'Remember to eat your dinner',
                        'position' => 3
                    ],
                ]
            ]
        ],
        'Home' => [
            [
                'title' => 'TODO',
                'taskList' => [
                    [
                        'title' => 'Clean house',
                        'position' => 1
                    ],
                    [
                        'title' => 'Wash dog',
                        'position' => 2
                    ],
                    [
                        'title' => 'Do the shopping',
                        'position' => 3
                    ],
                ]
            ]
        ],
        'Study' => [
            [
                'title' => 'Second year',
                'taskList' => [
                    [
                        'title' => 'Create SolidWorks Project',
                        'position' => 1
                    ],
                    [
                        'title' => 'Don\'t forget about exams in next week',
                        'position' => 2
                    ],
                    [
                        'title' => 'prepare for presentation about Angular',
                        'position' => 3
                    ],
                ]
            ]
        ],
        'I want to read' => [
            [
                'title' => 'MUST READ!',
                'taskList' => [
                    [
                        'title' => 'Clean architecture',
                        'position' => 1
                    ],
                    [
                        'title' => 'Latest blogposts from twitter pros',
                        'position' => 2
                    ]
                ]
            ]
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $this->createCategories($manager);
        $manager->flush();
        // ...
    }

    private function createCategories(ObjectManager $manager): void
    {
        foreach (self::DATA as $title => $data) {
            $category = new Category(
                Uuid::uuid4()->toString(),
                $title
            );
            $this->createCardList($category, $data, $manager);

            $manager->persist($category);
        }
    }


    private function createCardList(Category $category, array $cardListData, ObjectManager $manager)
    {

        foreach ($cardListData as $cardData) {
            $card = new Card(
                Uuid::uuid4()->toString(),
                $cardData['title'],
                $category
            );
            $this->createTaskList($cardData['taskList'], $card);
            $category->addCard($card);
        }
    }

    private function createTaskList(array $taskListData, Card $card): ArrayCollection
    {
        $taskList = new ArrayCollection();

        foreach ($taskListData as $taskData) {
            $taskList->add(new Task(
                Uuid::uuid4()->toString(),
                $taskData['title'],
                $taskData['position'],
                $card
            ));
        }

        return $taskList;
    }
}
