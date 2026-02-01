<?php
namespace App\Http\Requests\Career;


use Illuminate\Foundation\Http\FormRequest;


class StoreCareerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('career')?->id;
        return [
            'position' => ['required','string','max:191'],
            'number' => ['required','integer','min:1','max:100000'],
            'expiration_date' => ['required','date','after_or_equal:today'],
            'description' => ['nullable','string'],
            'is_open' => ['boolean'],
        ];
    }
}