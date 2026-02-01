<?php
namespace App\Http\Requests\News;


use Illuminate\Foundation\Http\FormRequest;


class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('news')?->id;
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . ($id ?? 'NULL') . ',id',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'cover_image_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ];
    }
}