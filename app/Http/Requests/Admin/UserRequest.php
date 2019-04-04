<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        //$this->request;
        //dd($this->route('user')->id);


        switch ($this->method())
        {
            case 'POST':
                {
                    return [
                        'name' => 'required',
                        'job_number' => 'required|unique:users,job_number'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    $id = $this->route('user')->id;
                    return [
                        'name' => 'required',
                        'job_number' => 'required|unique:users,job_number,'.$id
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            'name.required' => '姓名不为空',
            'job_number.required' => '工号不能为空',
            'job_number.unique' => '当前工号已存在',
        ];
    }
}
