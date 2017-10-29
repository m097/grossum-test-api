<?php

namespace CoreBundle\Service\Pagination;

use Symfony\Component\Serializer\Annotation as Serializer;

class PaginatedCollection
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $count;

    private $itemsKey = 'items';

    /**
     * PaginatedCollection constructor.
     * @param array $items
     * @param $totalItems
     */
    public function __construct(array $items, $totalItems)
    {
        $this->items = $items;
        $this->total = $totalItems;
        $this->count = count($items);
    }

    /**
     * @return array
     */
    public function getItems() : array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getItemsKey(): string
    {
        return $this->itemsKey;
    }

    /**
     * @param string $itemsKey
     *
     * @return $this
     */
    public function setItemsKey(string $itemsKey)
    {
        $this->itemsKey = $itemsKey;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount() : int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getTotal() : int
    {
        return $this->total;
    }
}
