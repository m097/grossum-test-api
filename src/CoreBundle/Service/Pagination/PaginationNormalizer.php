<?php

namespace CoreBundle\Service\Pagination;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        if (!$object instanceof PaginatedCollection) {
            throw new \InvalidArgumentException('The object must be an instance of '.PaginatedCollection::class);
        }

        if (!$this->serializer instanceof NormalizerInterface) {
            throw new \LogicException('Cannot normalize object because injected serializer is not a normalizer');
        }

        return [
            $object->getItemsKey() => $this->serializer->normalize($object->getItems(), $format, $context),
            'count' => $object->getCount(),
            'total' => $object->getTotal()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PaginatedCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        throw new \LogicException(sprintf('Cannot denormalize with "%s".', PaginatedCollection::class));
    }
}
