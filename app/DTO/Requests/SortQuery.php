<?php

namespace App\DTO\Requests;

use Illuminate\Http\Request;

class SortQuery
{
    private string $sortBy;
    private string $sortDirection;
    const VALID_SORT_FIELDS = ['created_at', 'updated_at', 'name', 'vote'];
    const VALID_SORT_DIRECTIONS = ['asc', 'desc'];

    public function __construct(Request $request) {
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'asc');

        if (!in_array($sortBy, self::VALID_SORT_FIELDS)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortDirection, self::VALID_SORT_DIRECTIONS)) {
            $sortDirection = 'asc';
        }

        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
    }

    public function hasSort(): bool
    {
        return !empty($this->sortBy) || !empty($this->sortDirection);
    }

    public function getSortBy(): string {
        return $this->sortBy;
    }

    public function getSortDirection(): string {
        return $this->sortDirection;
    }
}