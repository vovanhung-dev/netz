<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $req)
    {
        $q = Course::query()
            ->when($req->filled('search'), function ($qq) use ($req) {
                $kw = trim($req->get('search'));
                $qq->where(function($q2) use ($kw) {
                    $q2->where('title', 'like', "%{$kw}%")
                       ->orWhere('slug', 'like', "%{$kw}%")
                       ->orWhere('excerpt', 'like', "%{$kw}%");
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->select(['id','title','slug','excerpt','status','published_at','author_id','cover_image_url']);

        $perPage = (int) $req->integer('per_page', 10);
        $p = $q->paginate($perPage)->appends($req->query());

        return response()->json([
            'data'         => $p->items(),
            'current_page' => $p->currentPage(),
            'last_page'    => $p->lastPage(),
            'per_page'     => $p->perPage(),
            'total'        => $p->total(),
        ]);
    }

    public function indexGuest(Request $req)
    {
        $perPage = (int) $req->integer('per_page', 10);
        $p = Course::query()
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->select(['id','title','slug','excerpt','status','published_at','author_id','cover_image_url'])
            ->paginate($perPage)
            ->appends($req->query());

        return response()->json([
            'data'         => $p->items(),
            'current_page' => $p->currentPage(),
            'last_page'    => $p->lastPage(),
            'per_page'     => $p->perPage(),
            'total'        => $p->total(),
        ]);
    }

    public function show($id)
    {
        $course = Course::query()
            ->where('id', $id)
            ->select(['id','title','slug','excerpt','body','cover_image_url','status','published_at','author_id'])
            ->first();

        if (!$course) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'id'              => $course->id,
            'title'           => $course->title,
            'slug'            => $course->slug,
            'excerpt'         => $course->excerpt,
            'body'            => $course->body,
            'cover_image_url' => $course->cover_image_url,
            'cover_image_src' => $course->cover_image_src,
            'status'          => $course->status,
            'published_at'    => optional($course->published_at)?->toIso8601String(),
            'author_id'       => $course->author_id,
        ]);
    }

    public function showSlug($slug)
    {
        $course = Course::query()
            ->where('slug', $slug)
            ->select(['id','title','slug','excerpt','body','cover_image_url','status','published_at','author_id'])
            ->first();

        if (!$course) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'id'              => $course->id,
            'title'           => $course->title,
            'slug'            => $course->slug,
            'excerpt'         => $course->excerpt,
            'body'            => $course->body,
            'cover_image_url' => $course->cover_image_url,
            'cover_image_src' => $course->cover_image_src,
            'status'          => $course->status,
            'published_at'    => optional($course->published_at)?->toIso8601String(),
            'author_id'       => $course->author_id,
        ]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $old = $course->cover_image_url;

        $course->delete();

        if ($old && !Str::startsWith($old, ['http://','https://','//'])) {
            // be cautious: only delete within public disk news/courses folder
            Storage::disk('public')->delete($old);
        }

        return response()->json(['message' => 'Deleted']);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'title'        => 'required|string|max:191',
            'slug'         => 'nullable|string|max:191|unique:courses,slug',
            'excerpt'      => 'nullable|string|max:500',
            'body'         => 'nullable|string',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'author_id'    => 'nullable|integer',
            'image'        => 'sometimes|file|image|max:5120',
            'cover_image'  => 'sometimes|file|image|max:5120',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $i = 1;
            while (Course::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $base.'-'.$i++;
            }
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // If authenticated via sanctum, trust server-side author_id
        if ($req->user()) {
            $data['author_id'] = $req->user()->id;
        }

        $file = $req->file('image') ?? $req->file('cover_image');
        if ($file) {
            $img = $this->processCourseImage($file, null);
            if ($img) {
                $data['cover_image_url'] = $img['path'];
            }
        }

        $course = Course::create($data);

        return response()->json([
            'message' => 'Created',
            'data'    => $course->fresh(),
        ], 201);
    }

    public function update(Request $req, $id)
    {
        $course = Course::withoutGlobalScopes()->findOrFail($id);

        $slugRule = Rule::unique('courses', 'slug')->ignore($id);

        $data = $req->validate([
            'title'        => 'sometimes|required|string|max:191',
            'slug'         => ['sometimes','nullable','string','max:191', $slugRule],
            'excerpt'      => 'sometimes|nullable|string|max:500',
            'body'         => 'sometimes|nullable|string',
            'status'       => 'sometimes|required|in:draft,published',
            'published_at' => 'sometimes|nullable|date',
            'author_id'    => 'sometimes|nullable|integer',
            'image'        => 'sometimes|file|image|max:5120',
            'cover_image'  => 'sometimes|file|image|max:5120',
        ]);

        if (!array_key_exists('slug', $data) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $i = 1;
            while (Course::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $base.'-'.$i++;
            }
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $file = $req->file('image') ?? $req->file('cover_image');
        if ($file) {
            $img = $this->processCourseImage($file, $course->cover_image_url ?? null);
            if ($img) {
                $data['cover_image_url'] = $img['path'];
            }
        }

        $course->fill($data)->save();

        return response()->json([
            'message' => 'Updated',
            'data'    => array_merge(
                $course->toArray(),
                ['cover_image_src' => $course->cover_image_url ? Storage::disk('public')->url($course->cover_image_url) : null]
            ),
        ]);
    }

    private function processCourseImage($file, ?string $oldPath)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // optional: you can resize or encode here if needed
        // e.g., $image->coverDown(1600, 900);

        $dir = 'courses/' . date('Y/m/d');
        $name = uniqid('cover_', true) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
        $fileName = $dir . '/' . $name;

        Storage::disk('public')->put($fileName, (string) $image->toJpeg(85));

        if ($oldPath && !Str::startsWith($oldPath, ['http://','https://','//'])) {
            Storage::disk('public')->delete($oldPath);
        }

        return [
            'path' => $fileName,
            'url'  => Storage::disk('public')->url($fileName),
        ];
    }
}
