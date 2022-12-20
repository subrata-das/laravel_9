<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Validation\Rule;



class TaskDueDateSearchRequest extends FormRequest

{

    public function rules()

    {

        return [

            'due-date' => [
                'required',
                Rule::in(['Today', 'This Week', 'Next Week', 'Overdue']),
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

            'due-date.required' => 'due-date is required',

        ];

    }

}