<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\Request;
use App\Mail\HrCareerApplicationMail;
use App\Mail\ApplicantCareerConfirmationMail;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $numberItem = 10;
        $query = Career::orderBy("created_at", "DESC")->where('is_open', 1);

        $careers = $query->select(
            'id',
            'created_at as time',
            'position',
            'number',
            'description',
            'expiration_date',
            'is_open',
        )->paginate($numberItem);

        return $careers;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:191',
            'number' => 'required|integer|min:1',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
            'is_open' => 'boolean',
        ]);

        $career = Career::create($validated);
        return response()->json($career, 201);
    }

    public function show(Career $career)
    {
        return response()->json($career);
    }

    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:191',
            'number' => 'required|integer|min:1',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
            'is_open' => 'boolean',
        ]);

        $career->update($validated);
        return response()->json($career);
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function apply(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'phone'    => ['required','string','max:50'],
            'email'    => ['required','email','max:255'],
            'position' => ['nullable','string','max:255'],
            'address'  => ['nullable','string','max:255'],
            'cv_file'  => ['required','file','mimes:pdf,doc,docx','max:5120'],
        ]);

        // Lưu file vào storage/app/cv (tạo symlink nếu muốn public)
        $path = $request->file('cv_file')->store('cv');

        // Lưu hồ sơ ứng tuyển vào database
        CareerApplication::create([
            'career_id' => null,
            'name'      => $data['name'],
            'phone'     => $data['phone'],
            'email'     => $data['email'],
            'position'  => $data['position'] ?? null,
            'address'   => $data['address'] ?? null,
            'cv_path'   => $path,
        ]);

        // Gửi mail cho HR (đính kèm CV)
        $hrEmail = config('mail.hr_address');
        Mail::to($hrEmail)->send(new HrCareerApplicationMail($data, $path));

        // Gửi mail xác nhận cho ứng viên (không đính kèm)
        Mail::to($data['email'])->send(new ApplicantCareerConfirmationMail($data));

        return response()->json(['message' => 'Application sent successfully.'], 201);
    }
}

