<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ArticlesRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
