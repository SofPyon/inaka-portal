<?php

namespace App\Http\Controllers\Staff\Circles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\Circle;
use App\Eloquents\User;
use App\Eloquents\CircleUser;

class EditAction extends Controller
{
    public function __construct(User $user, CircleUser $circle_user)
    {
        $this->user = $user;
        $this->circle_user = $circle_user;
    }

    public function __invoke(Circle $circle)
    {
        $users = $this->user->all();
        $this->circle = $circle;
        $this->circle->leaders = $this->circle_user->getLeaders($this->circle);
        $this->circle->members = $this->circle_user->getMembers($this->circle);

        return view('staff.circles.edit')
            ->with('circle', $this->circle)
            ->with('users', $users);
    }
}
