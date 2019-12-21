<?php
declare(strict_types=1);

namespace UI\Controller;

use Domain\DTO\CategoryDTO;
use Domain\Model\Card;
use Domain\Model\Category;
use Domain\Service\CategoryServiceInterface;
use Infrastructure\Repository\CategoryRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private SerializerInterface $serializer;

    private CategoryServiceInterface $categoryService;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        SerializerInterface $serializer,
        CategoryServiceInterface $categoryService,
        CategoryRepository $categoryRepository
    ) {
        $this->serializer = $serializer;
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/categories", name="get-category", methods={"GET"})
     * @return Response
     */
    public function getAll(): Response
    {
        $categoryList = $this->categoryRepository->findAll();

        return new Response($this->serializer->serialize($categoryList, 'json'), Response::HTTP_OK);
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
