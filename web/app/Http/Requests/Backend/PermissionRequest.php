<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class PermissionRequest extends Request
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
            'index' => 'required|unique:permissions,index,' . $this->id,
            'name' => 'required|unique:permissions,name,' . $this->id,
            'status'   => 'integer|in:'.implode(',', array_keys(config('constant.status_list')))
        ];
    }
}
