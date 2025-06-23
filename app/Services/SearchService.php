<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use ElasticScoutDriverPlus\Support\Query;


class SearchService
{
    protected PaginationService $paginator;

    public function __construct(PaginationService $paginator)
    {
        $this->paginator = $paginator;
    }

    public function search(string $query = '', int $page = 1, int $perPage = 25): array
    {
        $from = ($page - 1) * $perPage;

        if (!empty($query)) {
            return $this->searchFromElastic($query, $from, $perPage);
        }

        return $this->searchFromDatabase();
    }

    private function searchFromElastic(string $query, int $from, int $perPage): array
    {
        $boolQuery = Query::bool()->must(
            Query::term()->field('title.keyword')->value($query)
        );

        if ($this->isUserGuard()) {
            $boolQuery->filter(
                Query::term()->field('user_id')->value(Auth::id())
            );
        }

        $postResponse = $this->executeElasticSearch(Post::class, $boolQuery, $from, $perPage);
        $folderResponse = $this->executeElasticSearch(Folder::class, $boolQuery, $from, $perPage);

        $combined = $this->combineResults([
            ['models' => $postResponse->models(), 'type' => 'Post'],
            ['models' => $folderResponse->models(), 'type' => 'Folder'],
        ]);

        return [
            'combined' => $combined,
            'total' => $postResponse->total() + $folderResponse->total(),
        ];
    }

    private function searchFromDatabase(): array
    {
        $userId = Auth::id();

        $posts = $this->isUserGuard()
            ? Post::all()
            : Post::where('user_id', $userId)->get();

        $folders = $this->isUserGuard()
            ? Folder::all()
            : Folder::where('user_id', $userId)->get();

        $combined = $this->combineResults([
            ['models' => $posts, 'type' => 'Post'],
            ['models' => $folders, 'type' => 'Folder'],
        ]);

        return [
            'combined' => $combined,
            'total' => $combined->count(),
        ];
    }

    private function executeElasticSearch(string $modelClass, $query, int $from, int $size)
    {
        return $modelClass::searchQuery($query)
            ->source(['id'])
            ->from($from)
            ->size($size)
            ->sort('id', 'desc')
            ->execute();
    }

    private function combineResults(array $results): Collection
    {
        return collect($results)
            ->flatMap(function ($item) {
                return collect($item['models'])->each->setAttribute('type', $item['type']);
            })
            ->sortByDesc('id')
            ->values();
    }

    private function isUserGuard(): bool
    {
        return Auth::guard('user')->check();
    }
}
