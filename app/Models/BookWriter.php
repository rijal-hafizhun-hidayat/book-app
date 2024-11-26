<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookWriter extends Model
{
    protected $table = 'book_writer';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
