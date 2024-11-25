<?php

namespace App\Services\Book;

use LaravelEasyRepository\BaseService;

interface BookService extends BaseService
{
    public function getBookWithCategory();
    public function storeBookWithBookCategory($request);
    public function findBookByBookId($id);
    public function destroyBookWithBookId($book);
}
