<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
        $rules = User::$rules;
        unset($rules['password']);
        if (auth()->user()->level() != 5) {
            unset($rules['roles']);
        }
        $rules['email'] = 'required|unique:users,email,' . collect(request()->segments())->last();
        $rules['username'] = 'required_without:email|unique:users,username,' . collect(request()->segments())->last();
        if (empty(request()->username)) {
            unset($rules['username']);
        }
        return $rules;
    }
}
