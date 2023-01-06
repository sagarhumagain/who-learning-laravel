<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseValidation extends FormRequest
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
            'name' => 'required',
            'description' => '',
            'credit_hours' => 'required|numeric',
            'url' => 'required',
            'source' => 'required',
            'completed_date'  => 'required_with:certificate_path',
            'certificate_path'  => 'required_with:completed_date'
        ];
    }
}
