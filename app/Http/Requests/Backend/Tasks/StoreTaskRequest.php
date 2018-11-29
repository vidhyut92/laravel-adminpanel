<?php

namespace App\Http\Requests\Backend\Tasks;

use App\Http\Requests\Request;

/**
 * Class StoreTaskRequest.
 */
class StoreTaskRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-task');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','min:3'],
            'status' => ['required','numeric']
        ];
    }
}
