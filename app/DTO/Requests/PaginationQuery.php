<?php

namespace App\DTO\Requests;

use Illuminate\Http\Request;

class PaginationQuery
{
    private int $page;
    private int $size;

    public function __construct(Request $request) {
        $this->page = (int) $request->input('page', 1);
        $this->size = (int) $request->input('size', 12);
    }

    public function getPage(): int {
        return $this->page;
    }

    public function getSize(): int {
        return $this->size;
    }
}