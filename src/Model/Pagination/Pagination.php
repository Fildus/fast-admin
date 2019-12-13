<?php

namespace DG\InstantAdminBundle\Model\Pagination;

class Pagination
{
    private int $currentPageNumber;
    private int $itemsPerPageNumber;
    private array $items;
    private int $itemsCount;

    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    public function setCurrentPageNumber(int $currentPageNumber): Pagination
    {
        $this->currentPageNumber = $currentPageNumber;

        return $this;
    }

    public function getItemsPerPageNumber(): int
    {
        return $this->itemsPerPageNumber;
    }

    public function setItemsPerPageNumber(int $itemsPerPageNumber): Pagination
    {
        $this->itemsPerPageNumber = $itemsPerPageNumber;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): Pagination
    {
        $this->items = $items;

        return $this;
    }

    public function getItemsCount(): int
    {
        return $this->itemsCount;
    }

    public function setItemsCount(int $itemsCount): Pagination
    {
        $this->itemsCount = $itemsCount;

        return $this;
    }
}
