<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignReviewerRequest extends FormRequest
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
        $reviewers = User::permission('reviews.create')->get()->pluck('id');
        return [
            'reviewers'     => 'required|array',
            'reviewers.*'   => [
                Rule::in($reviewers)
            ]
        ];
    }

    public function messages()
    {
        return [
            'reviewers.*.in'    => 'User is not a reviewer'
        ];
    }
}
