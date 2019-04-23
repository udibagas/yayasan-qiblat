<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_id' => 'required',
            'description_id' => 'required',
            'name_en' => 'required',
            'description_en' => 'required',
            'name_ar' => 'required',
            'description_ar' => 'required',
            'program_id' => 'required',
        ];
    }
}
