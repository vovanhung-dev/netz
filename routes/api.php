<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, NewsController, CareerController, ContactController, CourseController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Admin CRUD
    Route::apiResource('admin/news', NewsController::class)->parameters(['news' => 'news']);
    Route::put('admin/news/{news}', [NewsController::class, 'update']);
    Route::apiResource('admin/careers', CareerController::class)->parameters(['careers' => 'career']);
    Route::apiResource('admin/courses', CourseController::class)->parameters(['courses' => 'course']);
    Route::put('admin/courses/{course}', [CourseController::class, 'update']); // optional explicit PUT

    Route::get('contacts', function (\Illuminate\Http\Request $req) {
        $q = \App\Models\ContactMessage::query()
            ->when($req->filled('search'), fn($qq) => $qq
                ->where('name', 'like', '%' . $req->get('search') . '%')
                ->orWhere('phone', 'like', '%' . $req->get('search') . '%'))
            ->orderByDesc('id');
    
        $p = $q->paginate((int) $req->integer('per_page', 10))->appends($req->query());
        return response()->json([
            'data' => $p->items(),
            'current_page' => $p->currentPage(),
            'last_page' => $p->lastPage(),
            'per_page' => $p->perPage(),
            'total' => $p->total(),
        ]);
    });

    Route::get('contacts/{contact}', function (\App\Models\ContactMessage $contact) {
        return response()->json($contact);
    });

    // Career applications (admin)
    Route::get('career-applications', function (\Illuminate\Http\Request $req) {
        $q = \App\Models\CareerApplication::query()
            ->when($req->filled('search'), fn($qq) => $qq
                ->where('name', 'like', '%' . $req->get('search') . '%')
                ->orWhere('phone', 'like', '%' . $req->get('search') . '%')
                ->orWhere('email', 'like', '%' . $req->get('search') . '%')
                ->orWhere('position', 'like', '%' . $req->get('search') . '%'));

        $q->orderByDesc('id');

        $p = $q->paginate((int) $req->integer('per_page', 10))->appends($req->query());
        return response()->json([
            'data' => $p->items(),
            'current_page' => $p->currentPage(),
            'last_page' => $p->lastPage(),
            'per_page' => $p->perPage(),
            'total' => $p->total(),
        ]);
    });

    Route::get('career-applications/{application}', function (\App\Models\CareerApplication $application) {
        return response()->json($application);
    });
});

// Public routes
Route::get('/news', [NewsController::class, 'indexGuest']);
Route::get('/news/{slug}', [NewsController::class, 'showSlug']);
Route::get('/careers', [CareerController::class, 'index']);
Route::get('/careers/{slug}', [CareerController::class, 'show']);
Route::post('/careers/apply', [CareerController::class, 'apply']);
Route::get('/courses', [CourseController::class, 'indexGuest']);
Route::get('/courses/{slug}', [CourseController::class, 'showSlug']);

// Contact form với rate limiting
Route::middleware('throttle:contact')->post('/contact/send', [ContactController::class, 'send']);
