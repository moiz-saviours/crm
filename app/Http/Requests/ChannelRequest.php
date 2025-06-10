<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ChannelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $channelId = $this->route('channel')?->id;

        return [
            'special_key' => [
                'nullable',
                'integer',
                Rule::unique('channels')->ignore($channelId)
            ],
            'name' => 'required|string|max:100',
            'slug' => [
                'required',
                'alpha_dash',
                'max:120',
                Rule::unique('channels')->ignore($channelId)
            ],
            'url' => [
                'nullable',
                'url',
                'max:255',
                Rule::unique('channels')->ignore($channelId)
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
            'description' => 'nullable|string|max:500',
            'language' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
            'creator_type' => 'nullable|string|max:255',
            'creator_id' => 'nullable|integer',
            'owner_type' => 'nullable|string|max:255',
            'owner_id' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'meta_title' => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:200',
            'meta_keywords' => 'nullable|string',
            'last_activity_at' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'special_key.unique' => 'This special key is already in use',
            'slug.unique' => 'This slug is already in use',
            'url.unique' => 'This URL is already registered',
            'logo.image' => 'The logo must be a valid image file',
            'logo.max' => 'The logo must not exceed 2MB',
            'favicon.mimes' => 'The favicon must be a .ico or .png file',
            'favicon.max' => 'The favicon must not exceed 512KB',
            'status.in' => 'Invalid status value',
        ];
    }

    public function attributes()
    {
        return [
            'special_key' => 'special key',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'last_activity_at' => 'last activity',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('status')) {
            $this->merge(['status' => 0]);
        }

        if (!$this->slug && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }
    }
}
