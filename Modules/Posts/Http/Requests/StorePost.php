<?php

namespace Modules\Posts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required'],
            'images' => ['nullable'],
            'images.*' => ['exists:media,id']
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Content is required',
            'images.*.exists' => 'Image must be valid'
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
}
