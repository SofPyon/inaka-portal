<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Circle;
use App\Eloquents\User;

class Circle_user extends Model
{
    public $timestamps = false;
    protected $table = 'circle_user';
    protected $fillable = [
        'circle_id',
        'user_id',
        'is_leader',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function add(Circle $circle,User $user, $is_leader = false)
    {
        $this->create([
            'circle_id' => $circle->id,
            'user_id' => $user->id,
            'is_leader' => $is_leader,
        ]);
    }

    public function get_members(Circle $circle)
    {
        $members = $this->where('circle_id', $circle->id)->orderBy('is_leader', 'desc')->get();
        return $members;
    }

    public function get_leaders(Circle $circle)
    {
        $leaders = $this->where('circle_id', $circle->id)->where('is_leader', true)->get();
        if(empty($leaders))
        {
            return null;
        }
        foreach($leaders as $leader)
        {
            $leader = $leader->user();
        }
        return $leaders;
    }

    public function get_fes(Circle $circle)
    {
        $fes = $this->where('circle_id', $circle->id)->where('is_leader', false)->get();
        return $fes;
    }
}
