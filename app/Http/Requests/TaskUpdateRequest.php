<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Validation\Rule;



class TaskUpdateRequest extends FormRequest

{

    public function rules()

    {

        return [

            'states' => [
                'required',
                Rule::in(['Completed']),
            ],

        ];

    }



    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }



    public function messages()

    {

        return [

            'title.required' => 'Title is required',

            'states.required' => 'States is required'

        ];

    }

}