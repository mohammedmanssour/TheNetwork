<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')],
            'description' => ['nullable'],
            'password' => ['required', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please set valid email address',
            'email.unique' => 'Email is used before',
            'password.required' => 'Password and Password Confirmation are required',
            'password.confirmed' => 'Password and Password Confirmation must match',
        ];
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
     * transform password to encrypted value
     * @return array
     */
    public function transformed()
    {
        return
        collect(
            $this->validated()
        )->map(function($value, $key){
            if($key == 'password'){
                $value = bcrypt($value);
            }

            return $value;
        })->all();
    }
}
