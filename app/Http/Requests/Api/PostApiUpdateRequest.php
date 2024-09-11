<?php

namespace App\Http\Requests\Api;

use App\Models\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostApiUpdateRequest extends FormRequest
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
       'image' => 'nullable|image|max:2048',
        'categories' => 'required|array',
        'categories.*' => 'numeric|in:' . implode(',', Category::pluck('id')->toArray()),
        'publish_status' => 'required|in:' . implode(',', config('app.publish_statuses',[])),
         ];
}
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(["data"=>[],'message'=>'validation error ',"status"=>'fail',"errors"=> $validator->errors()->getMessages()],422));
    }

}
