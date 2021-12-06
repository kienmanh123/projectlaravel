<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProductRequest extends FormRequest
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
            'name' => 'required',
            'number' => 'required',
            'price' => 'required',
        ];
        if($this->id !=''){
            $arr['name'] =['required',
                Rule::unique('users')->where(function($query){
                return $query->where('id','!=',$this->id);
                }),
            ];
            $arr['img'] = ['required', Rule::unique('products')->ignore($this->product) ];
         }else{
                $arr['img'] = 'required';
                $arr['name']='required';
            }
            return $arr;
    }
    public function messages()
    {
        $arrMsg = [
            'number.required' =>'Vui lòng nhập số lượng sản phẩm',
            'price.required' =>'Vui lòng nhập giá tiền sản phẩm',
        ];
        if($this->id !=''){
            $arrMsg['name.required']='Vui lòng nhập tên sản phẩm';
            $arrMsg['name.unique']='Tên sản phẩm đã tồn tại';
        }else{
            $arrMsg['img.unique']='Vui lòng nhập hình ảnh sản phẩm';
            $arrMsg['name.unique']='Tên sản phẩm đã tồn tại';

        }
        return $arrMsg;
    }
}
