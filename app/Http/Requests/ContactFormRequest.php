<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
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
            'circle_id' => 'filled',
            'contact-body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact-body.required' => 'お問い合わせ内容は必ず入力してください',
        ];
    }

    public function withValidator($validator)
    {
        // $validator->after(function ($validator) {
        //     if ($this->somethingElseIsInvalid()) {
        //         $validator->errors()->add('field', 'Something is wrong with this field!');
        //     }
        // });
    }
}
