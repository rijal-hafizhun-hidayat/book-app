<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publisher';
    protected $guarded = ['id'];

    public function bookPublisher()
    {
        return $this->hasMany(BookPublisher::class, 'publisher_id', 'id');
    }
}
