<?php

namespace App\Services\BookPublisher;

use LaravelEasyRepository\BaseService;

interface BookPublisherService extends BaseService
{

    // Write something awesome :)
    public function storeBookPublisher($request, $book);
    public function destroyBookPublisherByBookId($bookId);
}
