<?php


namespace App\Repository;


use App\Contract\ArticleRepository;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements ArticleRepository
{

    public function search(string $query = ''): Collection
    {
        return Article::query()
            ->where('title', 'like', "%{$query}%")
            ->get();
    }
}
