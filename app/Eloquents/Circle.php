<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\User;
use App\Eloquents\CircleUser;

class Circle extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(CircleUser::class)->withPivot('is_leader');
    }
}
