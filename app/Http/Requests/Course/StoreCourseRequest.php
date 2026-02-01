<?php
namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('course')?->id;
        $slugRule = $id
            ? Rule::unique('courses','slug')->ignore($id)
            : Rule::unique('courses','slug');

        return [
            'title'        => ['required','string','max:191'],
            'slug'         => ['nullable','string','max:191', $slugRule],
            'excerpt'      => ['nullable','string','max:500'],
            'body'         => ['nullable','string'],
            'status'       => ['required','in:draft,published'],
            'published_at' => ['nullable','date'],
            'author_id'    => ['nullable','integer'],
            'image'        => ['sometimes','file','image','max:5120'],
            'cover_image'  => ['sometimes','file','image','max:5120'],
        ];
    }
}
