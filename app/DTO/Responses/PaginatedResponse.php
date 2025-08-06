<?php 

namespace App\DTO\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatedResponse
{
    public mixed $items;
    public int $total;
    public int $page;
    public int $size;

    public function __construct(mixed $items, int $total, int $page, int $size)
    {
        $this->items = $items;
        $this->total = $total;
        $this->page = $page;
        $this->size = $size;
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'total' => $this->total,
            'page' => $this->page,
            'size' => $this->size,
        ];
    }
}
