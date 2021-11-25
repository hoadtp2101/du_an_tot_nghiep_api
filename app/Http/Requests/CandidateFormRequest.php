<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidateFormRequest extends FormRequest
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
            'name' => 'required|min:4',            
            'image' => [
                "mimes:jpg,bmp,png"
            ],            
            'email' => [
                "required",
                "email"
            ],            
            'phone' => [
                "required",                 
            ],            
            'source' => [
                "required",               
            ],            
            'experience' => [
                "required",
                "numeric",
                "min:0"
            ],            
            'school' => [
                "required",
            ],            
            'cv' => [
                "mimes:pdf,doc,docx"
            ],            
            'status' => [
                "required",
            ],            
        ];
        if($this->id == null){
            $formRules['cv'][] = "required";
        }        
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => [$validator->errors()],
            'items' => null], 440));
    }
}
