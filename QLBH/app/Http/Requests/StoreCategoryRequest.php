<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name'  => 'required|string|max:255',
            'image' => 'nullable|string',

            'parent_id' => [
                'nullable',
                'exists:categories,id',
                'not_in:' . $categoryId //  không cho làm cha chính nó
            ]
        ];
    }
}