<?php

namespace App\Http\Controllers\Staff\Circles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Eloquents\User;
use App\Eloquents\Circle;

class CreateAction extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke(Request $request)
    {
        $messages = [
            'name.required' => '団体名は必ず入力してください',
            'name.unique'   => 'すでに存在する団体名です',
            'name.max'      => '255文字以下で入力してください',
            'leader.exists' => 'この学籍番号は登録されていません',
            'regex'         => '学籍番号を確認してください',
        ];

        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'unique:circles,name', 'max:255'],
            'leader'    => ['nullable', 'regex:/^[0-9a-z ]*$/', 'exists:users,student_id'],
            'members'   => ['nullable', 'regex:/^[0-9a-z (\r\n)]*$/'],
        ], $messages);

        $members_id = str_replace(["\r\n", "\r", "\n"], "\n", $request->members);
        $members_id = explode("\n", $members_id);
        $members_id = array_filter($members_id, "strlen") ;

        // members 存在チェック
        $notregister = null;
        $members = [];
        foreach ($members_id as $member) {
            $member_id = $member;
            $member = $this->user->getUserByStudentId($member);
            if (empty($member)) {
                $notregister .= $member_id . ' ';
            }
            array_push($members, $member);
        }
        $validator->after(function ($validator) use ($notregister) {
            if (!empty($notregister)) {
                $validator->errors()->add('members', '未登録：' . $notregister);
            }
        });

        if ($validator->fails()) {
            return redirect()
            ->route('staff.circles.create')
            ->withErrors($validator)
            ->withInput();
        }

        // 保存処理
        $circle = Circle::create([
            'name'  => $request->name,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        $circle->users()->detach();
        $leader = $this->user->getUserByStudentId($request->leader);
        $leader->circles()->attach(1, ['circle_id' => $circle->id, 'user_id' => $leader->id, 'is_leader' => true]);
        foreach ($members as $member) {
            $member->circles()->attach(1, ['circle_id' => $circle->id, 'user_id' => $member->id, 'is_leader' => false]);
        }
        return redirect('/home_staff/circles/read/' . $circle->id);
    }
}
