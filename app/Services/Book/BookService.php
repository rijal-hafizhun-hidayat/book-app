<?php

namespace App\Services\Book;

use LaravelEasyRepository\BaseService;

interface BookService extends BaseService
{
    public function getBookWithCategoryAndPublisherAndWriter();
    public function storeBookWithBookCategory($request);
    public function findBookByBookId($id);
    public function destroyBookWithBookId($book);
    public function updateBookWithBookCategoryByBookId($request, $book);
}
