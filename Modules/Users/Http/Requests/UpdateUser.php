<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateUser extends StoreUser
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['email'] = ['required', 'email', Rule::unique('users')->ignore(auth()->user()->id)];
        $rules['password'] = ['nullable', 'confirmed'];
        $rules['profile_picture'] = ['nullable', 'exists:media,id'];
        $rules['cover'] = ['nullable', 'exists:media,id'];

        return $rules;
    }

    public function messages()
    {
        $messages = parent::messages();

        $messages['profile_picture.exists'] = 'Profile picture isn\'t valid';
        $messages['cover.exists'] = 'Cover photo isn\'t valid';

        return $messages;
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
        )->when(!$this->password, function($collect){
            return $collect->forget('password');
        })
        ->map(function ($value, $key) {
            if ($key == 'password') {
                $value = bcrypt($value);
            }

            return $value;
        })->all();
    }
}
