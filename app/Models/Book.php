<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $guarded = ['id'];

    public function bookCategory()
    {
        return $this->hasMany(BookCategory::class, 'book_id', 'id');
    }

    public function bookPublisher()
    {
        return $this->hasOne(BookPublisher::class, 'book_id', 'id');
    }

    public function bookWriter()
    {
        return $this->hasMany(BookWriter::class, 'book_id', 'id');
    }
}
