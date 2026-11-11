<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAffiliateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('user_id', $this->user()->id),
            ],
            'title' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'string', 'url:http,https', 'max:2048'],
            'affiliate_url' => ['required', 'string', 'url:http,https', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'Pilih kategori milikmu sendiri.',
            'image.url' => 'Gambar harus berupa tautan yang valid.',
            'affiliate_url.url' => 'Tautan affiliate harus berupa URL yang valid.',
        ];
    }
}
