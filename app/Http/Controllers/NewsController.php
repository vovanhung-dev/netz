<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index(Request $req)
    {
        $q = News::query()
            ->when($req->filled('search'), function ($qq) use ($req) {
                $kw = trim($req->get('search'));
                $qq->where('title', 'like', "%{$kw}%")
                   ->orWhere('slug', 'like', "%{$kw}%")
                   ->orWhere('excerpt', 'like', "%{$kw}%");
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
        $perPage = $req->integer('per_page', 10);
        $p = News::query()
            ->where('status', 'published')
            ->orderByDesc('created_at')
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
        $news = News::query()
            ->where('id', $id)
            ->select(['id','title','slug','excerpt','body','cover_image_url','status','published_at','author_id'])
            ->first();

        if (!$news) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'id'              => $news->id,
            'title'           => $news->title,
            'slug'            => $news->slug,
            'excerpt'         => $news->excerpt,
            'body'            => $news->body,
            'cover_image_url' => $news->cover_image_url,
            'cover_image_src' => $news->cover_image_src,
            'status'          => $news->status,
            'published_at'    => optional($news->published_at)->format('Y-m-d H:i:s'),
            'author_id'       => $news->author_id,
        ]);
    }

    public function showSlug($slug)
    {
        $news = News::query()
            ->where('slug', $slug)
            ->select(['id','title','slug','excerpt','body','cover_image_url','status','published_at','author_id'])
            ->first();

        if (!$news) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json([
            'id'              => $news->id,
            'title'           => $news->title,
            'slug'            => $news->slug,
            'excerpt'         => $news->excerpt,
            'body'            => $news->body,
            'cover_image_url' => $news->cover_image_url,
            'cover_image_src' => $news->cover_image_src,
            'status'          => $news->status,
            'published_at'    => optional($news->published_at)->format('Y-m-d H:i:s'),
            'author_id'       => $news->author_id,
        ]);
    }

    public function destroy(News $news)
    {
        if (!empty($news->cover_image_url)) {
            Storage::disk('public')->delete($news->cover_image_url);
        }
        $news->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function processNewsImage(?\Illuminate\Http\UploadedFile $file, ?string $oldPath = null): ?array
    {
        if (!$file) {
            return null;
        }

        $fileName = 'news/' . uniqid() . '_' . time() . '.webp';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath())
            ->scaleDown(1200, null)
            ->toWebp(85);

        $binary = $image->toString();

        Storage::disk('public')->put($fileName, $binary);

        if (!empty($oldPath) && $oldPath !== $fileName) {
            Storage::disk('public')->delete($oldPath);
        }

        return [
            'path' => $fileName,
            'url'  => Storage::disk('public')->url($fileName),
        ];
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'title'        => 'required|string|max:191',
            'slug'         => 'nullable|string|max:191|unique:news,slug',
            'excerpt'      => 'nullable|string',
            'body'         => 'nullable|string',
            'status'       => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'author_id'    => 'nullable|integer',
            'image'        => 'sometimes|file|image|max:5120',
            'cover_image'  => 'sometimes|file|image|max:5120',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $i = 1;
            while (News::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $base.'-'.$i++;
            }
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $file = $req->file('image') ?? $req->file('cover_image');
        if ($file) {
            $img = $this->processNewsImage($file, null);
            if ($img) {
                $data['cover_image_url'] = $img['path'];
            }
        }

        $news = News::create($data);

        return response()->json([
            'message' => 'Created',
            'data'    => $news->fresh(),
        ], 201);
    }

    public function update(Request $req, $id)
    {
        $news = News::withoutGlobalScopes()->findOrFail($id);

        $slugRule = Rule::unique('news', 'slug')->ignore($id);

        $data = $req->validate([
            'title'        => 'sometimes|required|string|max:191',
            'slug'         => ['sometimes','required','string','max:191', $slugRule],
            'excerpt'      => 'sometimes|nullable|string',
            'body'         => 'sometimes|nullable|string',
            'status'       => 'sometimes|required|in:draft,published,archived',
            'published_at' => 'sometimes|nullable|date',
            'author_id'    => 'sometimes|nullable|integer',
            'image'        => 'sometimes|file|image|max:5120',
            'cover_image'  => 'sometimes|file|image|max:5120',
        ]);

        if (!array_key_exists('slug', $data) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
            $base = $data['slug'];
            $try  = $base;
            $i    = 1;
            while (News::where('slug', $try)->where('id', '!=', $id)->exists()) {
                $try = $base.'-'.$i++;
            }
            $data['slug'] = $try;
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $file = $req->file('image') ?? $req->file('cover_image');
        if ($file) {
            $img = $this->processNewsImage($file, $news->cover_image_url ?? null);
            if ($img) {
                $data['cover_image_url'] = $img['path'];
            }
        }

        $news->fill($data)->save();

        return response()->json([
            'message' => 'Updated',
            'data'    => array_merge(
                $news->toArray(),
                ['cover_image_src' => $news->cover_image_url ? Storage::disk('public')->url($news->cover_image_url) : null]
            ),
        ]);
    }
}
