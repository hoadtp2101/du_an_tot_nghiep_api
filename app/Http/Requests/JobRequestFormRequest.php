<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JobRequestFormRequest extends FormRequest
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
        $formRules = [            
            'title' => [
                "required",     
                "min:5",                   
            ],            
            'description' => [
                "required",
            ],            
            'position' => [
                "required",
                "min:5",                
                "max:150",
            ],            
            'amount' => [
                "numeric",
                "min:0"
            ],            
            'location' => [
                "required",               
            ],            
            'working_time' => [
                "required",
            ],          
            'wage' => [
                "required", 
            ],            
            'deadline' => [
                "required",
                "after:yesterday"
            ],            
        ];        
        return $formRules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => [$validator->errors()],
            'items' => null], 440));
    }
}
