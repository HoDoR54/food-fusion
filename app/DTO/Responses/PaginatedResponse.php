<?php 

namespace App\DTO\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatedResponse
{
    public array $data;
    public int $currentPage;
    public int $totalPages;
    public int $totalItems;
    public int $itemsPerPage;
    public bool $hasNextPage;
    public bool $hasPreviousPage;

    public function __construct(
        array $data,
        int $currentPage,
        int $totalPages,
        int $totalItems,
        int $itemsPerPage
    ) {
        $this->data = $data;
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
            data: $transformedData,
            currentPage: $paginator->currentPage(),
            totalPages: $paginator->lastPage(),
            totalItems: $paginator->total(),
            itemsPerPage: $paginator->perPage()
        );
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
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
