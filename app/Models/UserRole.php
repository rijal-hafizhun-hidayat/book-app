<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';
    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
