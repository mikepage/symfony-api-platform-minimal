<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BaseController extends AbstractController
{
    public function __construct(
        protected SerializerInterface $serializer,
        protected EntityManagerInterface $entityManager
    ) {
    }

    protected function json(
        mixed $data,
        int $status = Response::HTTP_OK,
        array $headers = [],
        array $context = []
    ): JsonResponse {
        $json = $this->serializer->serialize(
            $data,
            'json',
            [
                AbstractNormalizer::GROUPS => $context['groups'] ?? [],
                AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 1,
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn($object) => $object->getId(),
                AbstractNormalizer::IGNORED_ATTRIBUTES => [
                    '__cloner__',
                    '__initializer__',
                    '__isInitialized__',
                    'getStateMachineDefinition',
                    'lazyPropertiesNames',
                    'lazyPropertiesDefaults'
                ],
            ]
        );

        return new JsonResponse($json, $status, $headers, true);
    }

}