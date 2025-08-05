<?php
// app/Http/Requests/PropertyRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zipcode' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|integer|min:0',
            'type' => 'required|in:apartment,house,condo,villa',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB max
        ];

        if ($this->isMethod('post')) {
            $rules['name'][] = 'unique:properties,name';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'][] = Rule::unique('properties')->ignore($this->property);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.unique' => 'A property with this name already exists.',
            'description.min' => 'Description must be at least 10 characters.',
            'images.*.max' => 'Each image must not exceed 5MB.',
            'images.*.image' => 'Each file must be an image.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'featured' => $this->featured ?? false,
        ]);
    }
}