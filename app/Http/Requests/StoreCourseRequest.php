<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'course_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120', // Max 5MB
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:102400', // Max 100MB
            'selling_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:selling_price',
            'duration' => 'required|string|max:50',
            'resources' => 'nullable|string|max:500',
            'label' => 'nullable|in:Beginner,Intermediate,Expert',
            'prerequisites' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'bestseller' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'highestrated' => 'nullable|boolean',
            
        ];
    }
}
