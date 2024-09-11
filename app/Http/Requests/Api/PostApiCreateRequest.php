<?php

namespace App\Http\Requests\Api;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class PostApiCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'required|image|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'numeric|in:' . implode(',', Category::pluck('id')->toArray()),
        ];
    }
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(["data"=>[],'message'=>'validation error ',"status"=>'fail',"errors"=> $validator->errors()->getMessages()],422));
    }
}
