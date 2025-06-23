<?php
namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PaginationService
{
    public function paginate(Collection $items, int $total, int $perPage, int $currentPage): LengthAwarePaginator
    {
        $slice = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $slice,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => url()->current(),
                'query' => request()->query(),
            ]
        );
    }
}
