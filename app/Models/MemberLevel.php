<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    protected $table = 'member_levels';
    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(User::class);
    }
}
