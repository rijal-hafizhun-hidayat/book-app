<?php

namespace App\Services\BookRecap;

use LaravelEasyRepository\BaseService;

interface BookRecapService extends BaseService
{

    // Write something awesome :)
    public function getDataByCategory();
    public function getDataByPublisher();
    public function getDataByWriter();
}
