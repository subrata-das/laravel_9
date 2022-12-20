<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Validation\Rule;



class TaskTitleSearchRequest extends FormRequest

{

    public function rules()

    {

        return [

            // 'search-type' => [
            //     'required',
            //     Rule::in(['title', 'due-date']),
            // ],

            // 'due-date' => [
            //     Rule::in(['Today', 'This Week', 'Next Week', 'Overdue']),
            // ],

            'title' => 'required|max:255'

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

            'title.required' => 'title is required',

        ];

    }

}