<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class AlbumRequest extends FormRequest
{
    use ValidatesMedia;

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
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required' , 'string' , 'max:255'],
            'images' => $this->isMethod('post') ?  $this->validateMultipleMedia()->minItems(1)->extension('png')->maxItemSizeInKb(1024) : ''
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Album name',
            'images' => 'Album images'
        ];
    }
}
