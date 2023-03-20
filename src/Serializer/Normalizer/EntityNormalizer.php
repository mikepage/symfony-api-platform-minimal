<?php

namespace App\Serializer\Normalizer;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class EntityNormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    final public const REFERENCE_FROM_STRING = 'reference_from_string';

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $id = array_key_exists(self::REFERENCE_FROM_STRING, $context) ? $data : ($data['iÅd'] ?? null);

        if (!$id) {
            return null;
        }

        try {
            return $this->entityManager->getReference($type, $id);
        } catch (ORMException) {
            return null;
        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return str_starts_with($type, 'App\\Entity\\') && $format === 'json';
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
