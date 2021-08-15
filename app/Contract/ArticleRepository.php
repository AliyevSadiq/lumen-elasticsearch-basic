<?php


namespace App\Contract;

use Illuminate\Database\Eloquent\Collection;

interface ArticleRepository
{
    public function search(string $query = ''): Collection;
}
