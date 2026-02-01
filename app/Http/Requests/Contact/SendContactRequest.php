<?php
namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name'    => ['required','string','max:191'],
            'phone'   => ['required','string','max:50','regex:/^[0-9+()\s-]{6,}$/'],
            'email'   => ['nullable','email','max:191'],
            'content' => ['nullable','string','max:5000'],
        ];
    }
    public function messages(): array {
        return [
            'name.required'  => 'Please enter your name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex'    => 'Phone format is invalid.',
            'email.email'    => 'Email is invalid.',
        ];
    }
}
