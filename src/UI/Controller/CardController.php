<?php
declare(strict_types=1);

namespace UI\Controller;

use Application\Service\CardService;
use Domain\DTO\CardDTO;
use Domain\Model\Card;
use Infrastructure\Repository\CardRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    private SerializerInterface $serializer;

    private CardService $cardService;

    private CardRepository $cardRepository;

    public function __construct(SerializerInterface $serializer, CardService $cardService, CardRepository $cardRepository)
    {
        $this->serializer = $serializer;
        $this->cardService = $cardService;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/cards", name="create-card", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $cardDTO = $this->serializer->deserialize($request->getContent(), CardDTO::class, 'json');

        $card = $this->cardService->create($cardDTO);

        return new Response($this->serializer->serialize($card, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/cards/{id}", name="update-card", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function update(Card $card, Request $request): Response
    {
        $cardDTO = $this->serializer->deserialize($request->getContent(), CardDTO::class, 'json');

        $card = $this->cardService->update($card, $cardDTO);

        return new Response($this->serializer->serialize($card, 'json'), Response::HTTP_CREATED);
    }

    /**
     * @Route("/cards", name="get-all-cards", methods={"GET"})
     * @return Response
     */
    public function getALl(): Response
    {
        return new Response(
            $this->serializer->serialize(
                $this->cardRepository->findAll(),
                'json'
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/cards/{id}", name="remove-cards", methods={"DELETE"})
     * @return Response
     */
    public function remove(Card $card): Response
    {
        $this->cardRepository->remove($card);

        return new JsonResponse('Card removed', Response::HTTP_OK);
    }
}
