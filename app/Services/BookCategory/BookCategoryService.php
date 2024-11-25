<?php

namespace App\Services\BookCategory;

use LaravelEasyRepository\BaseService;

interface BookCategoryService extends BaseService
{

    // Write something awesome :)
    public function storeBookCategory($request, $book);
}
