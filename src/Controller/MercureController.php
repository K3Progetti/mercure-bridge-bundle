<?php


namespace K3Progetti\MercureBridgeBundle\Controller;

use App\Utils\Result;
use Exception;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MercureController extends AbstractController
{

    public function __construct(

        private readonly Result              $result,
        private readonly NormalizerInterface $normalizer,
    )
    {


    }

    /**
     * Get Operators
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/public/mercure/token', name: 'get_mercure_token', methods: 'GET')]
    public function getOperators(Request $request): JsonResponse
    {

        //
        try {

            $secret = $this->getParameter('mercureJwtSecret');
            $topic = $this->getParameter('mercureTopic');

            if (!$topic) {
                return $this->json(['error' => 'Topic mancante'], 400);
            }

            $payload = [
                'mercure' => [
                    'subscribe' => [$topic]
                ],
            ];

            $jwt = JWT::encode($payload, $secret, 'HS256');

            $this->result->setData(
                $this->normalizer->normalize(
                    ['jwt' => $jwt],
                    'json',
                    []
                ),
            );

            return new JsonResponse($this->result->toArray());
        } catch (Exception $e) {
            $this->result->setMessage($e->getMessage());
            return new JsonResponse($this->result->toArray(), 422);
        }
    }


}


