<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrunksRequest extends FormRequest
{
    ///protected $redirect = '/trunks';

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
            'trunkName' => 'required',
            'host' => 'required',
        ];
    }
}
