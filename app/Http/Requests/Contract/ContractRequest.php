<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'contract_start' => 'required',
            'contract_end' => 'required',
            'staff_type_id' => 'required',
            'contract_type_id' => 'required',
            'designation_id' => 'required',
            'staff_category_id' => 'required',
            'is_active' => 'required',
            'unit_id' => 'required',
        ];
    }
}
