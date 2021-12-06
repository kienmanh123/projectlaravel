<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
        ];
    }
    public function messages(){
        return[
            'name.required' =>'Vui lòng nhập tên',
            'email.required' =>'Vui lòng nhập email',
            'email.email' =>'Địa chỉ email không đúng',
            'address.required' =>'Vui lòng nhập địa chỉ', ];
    }
}
