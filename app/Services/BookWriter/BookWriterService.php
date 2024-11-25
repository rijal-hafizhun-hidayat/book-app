<?php

namespace App\Services\BookWriter;

use LaravelEasyRepository\BaseService;

interface BookWriterService extends BaseService
{

    // Write something awesome :)
    public function storeBookWriter($request, $book);
    public function destroyBookWriterByBookId($bookId);
}
