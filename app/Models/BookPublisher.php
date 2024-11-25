<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookPublisher extends Model
{
    protected $table = 'book_publisher';
    protected $guarded = ['id'];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }
}
