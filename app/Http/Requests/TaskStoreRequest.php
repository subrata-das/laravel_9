<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;



class TaskStoreRequest extends FormRequest

{

    public function rules()

    {

        return [

            'title' => 'required|unique:tasks|max:255',
            'due-date' => 'required|date',
            'parent-task' => 'max:255'
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

            'due-date.required' => 'Body is required'

        ];

    }

}