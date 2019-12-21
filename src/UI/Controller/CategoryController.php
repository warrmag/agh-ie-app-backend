<?php
declare(strict_types=1);

namespace UI\Controller;

use Domain\DTO\CategoryDTO;
use Domain\Model\Card;
use Domain\Model\Category;
use Domain\Service\CategoryServiceInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private SerializerInterface $serializer;

    private CategoryServiceInterface $categoryService;

    public function __construct(SerializerInterface $serializer, CategoryServiceInterface $categoryService)
    {
        $this->serializer = $serializer;
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/categories", name="create-category", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $categoryDTO = $this->serializer->deserialize($request->getContent(), CategoryDTO::class, 'json');
        $category = $this->categoryService->create($categoryDTO);

        return new Response($this->serializer->serialize($category, 'json'), Response::HTTP_ACCEPTED);
    }
}
