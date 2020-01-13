<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowTaskRequest extends FormRequest
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
            'target_fans' => ['required','numeric','min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'target_fans'=>'目标粉丝'
        ];
    }
}
