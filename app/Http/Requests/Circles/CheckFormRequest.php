<?php

namespace App\Http\Requests\Circles;

use Illuminate\Foundation\Http\FormRequest;
use App\Eloquents\User;

class CheckFormRequest extends FormRequest
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'max:255'],
            'leader'    => ['nullable', 'exists:users,student_id'],
            'members'   => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '団体名は必ず入力してください',
            'name.unique'   => 'すでに存在する団体名です',
            'name.max'      => '255文字以下で入力してください',
            'leader.exists' => 'この学籍番号は登録されていません',
        ];
    }

    public function withValidator($validator)
    {
        $not_verify = [];

        $member_ids = str_replace(["\r\n", "\r", "\n"], "\n", $this->members);
        $member_ids = explode("\n", $member_ids);
        $member_ids = array_filter($member_ids, "strlen");

        $members = $this->user->getByStudentIdIn($member_ids);

        foreach ($members as $member) {
            $member_ids = array_diff($member_ids, [$member->student_id]);
            ($member->areBothEmailsVerified() ? '' : array_push($not_verify, $member->student_id));
        }
        $validator->after(function ($validator) use ($member_ids, $not_verify) {
            if (!empty($member_ids)) {
                $validator->errors()->add('members', '未登録：' . implode(' ', $member_ids));
            }

            if (!empty($not_verify)) {
                $validator->errors()->add('members', 'メール未認証：' . implode(' ', $not_verify));
            }
        });
    }
}
