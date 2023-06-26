<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTraining extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Get the validation attribute names
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'トレーニング名',
            'description' => 'トレーニング内容',
            'category_id' => '部位カテゴリー',
        ];
    }
}
