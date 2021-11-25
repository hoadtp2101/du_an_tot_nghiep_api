<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewsFormRequest extends FormRequest
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
            'thinking' => [
                "required",
                "numeric",
                "min:0",
                "max:10"                     
            ],            
            'persistent_perseverance' => [
                "required",
                "numeric",
                "min:0",
                "max:10"
            ],            
            'career_goals' => [
                "required",
                "numeric",
                "min:0",
                "max:10"
            ],            
            'specialize_skill' => [
                "numeric",
                "min:0",
                "max:10" 
            ],            
            'english' => [
                "required",    
                "numeric",
                "min:0",
                "max:10"           
            ],            
            'adaptability' => [
                "required",
                "numeric",
                "min:0",
                "max:10"
            ],          
            'time_onbroad' => [
                "required", 
            ],            
            'reviews' => [
                "required",                
            ],            
            'result' => [
                "required",                
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
