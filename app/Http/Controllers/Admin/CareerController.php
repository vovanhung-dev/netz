<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\StoreCareerRequest;
use App\Http\Requests\Career\UpdateCareerRequest;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $q = Career::query()
            ->when($req->boolean('is_open', null) !== null, fn($qq) => $qq->where('is_open', $req->boolean('is_open')))
            ->when($req->boolean('active'), fn($qq) => $qq->whereDate('expiration_date', '>=', now()->toDateString()))
            ->search($req->string('search')->toString() ?: null)
            ->orderByDesc('id');

        $perPage = (int) $req->integer('per_page', 10);
        $paginator = $q->paginate($perPage)->appends($req->query());

        return CareerResource::collection($paginator);
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        return CareerResource::make($career);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCareerRequest $req)
    {
        $career = Career::create($req->validated());
        return response()->json([
            'message' => 'Created',
            'data' => CareerResource::make($career),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCareerRequest $req, Career $career)
    {
        $career->update($req->validated());
        return response()->json([
            'message' => 'Updated',
            'data' => CareerResource::make($career),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return response()->json(['message' => 'Deleted']);
    }
}