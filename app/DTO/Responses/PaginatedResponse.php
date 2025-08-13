<?php 

namespace App\DTO\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatedResponse
{
    private array $items;
    private int $currentPage;
    private int $totalPages;
    private int $totalItems;
    private int $itemsPerPage;
    private bool $hasNextPage;
    private bool $hasPreviousPage;

    public function __construct(
        array $items,
        int $currentPage,
        int $totalPages,
        int $totalItems,
        int $itemsPerPage
    ) {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->hasNextPage = $currentPage < $totalPages;
        $this->hasPreviousPage = $currentPage > 1;
    }

    public static function fromPaginator(LengthAwarePaginator $paginator, array $transformedData): self
    {
        return new self(
            items: $transformedData,
            currentPage: $paginator->currentPage(),
            totalPages: $paginator->lastPage(),
            totalItems: $paginator->total(),
            itemsPerPage: $paginator->perPage()
        );
    }

    public function getCurrentPage(): int { return $this->currentPage; }
    public function getTotalPages(): int { return $this->totalPages; }
    public function getTotalItems(): int { return $this->totalItems; }
    public function getItemsPerPage(): int { return $this->itemsPerPage; }
    public function getHasNextPage(): bool { return $this->hasNextPage; }
    public function getHasPreviousPage(): bool { return $this->hasPreviousPage; }
        public function getItems(): array {
        return $this->items;
    }

    public function getPagination(): array
    {
        return [
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'total_items' => $this->totalItems,
            'items_per_page' => $this->itemsPerPage,
            'has_next_page' => $this->hasNextPage,
            'has_previous_page' => $this->hasPreviousPage,
        ];
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(function($item) {
                if (is_object($item) && method_exists($item, 'toArray')) {
                    return $item->toArray();
                }
                return $item;
            }, $this->items),
            'pagination' => [
                'current_page' => $this->currentPage,
                'total_pages' => $this->totalPages,
                'total_items' => $this->totalItems,
                'items_per_page' => $this->itemsPerPage,
                'has_next_page' => $this->hasNextPage,
                'has_previous_page' => $this->hasPreviousPage,
            ],
        ];
    }
}
