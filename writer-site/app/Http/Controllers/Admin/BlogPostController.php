<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog.create');
    }

    public function store(Request $request): RedirectResponse
    {
        app()->setLocale('es');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'order' => ['nullable', 'integer'],
        ], [
            'title.required' => 'El título del artículo es obligatorio.',
            'title.max' => 'El título no puede tener más de 255 caracteres.',
            'excerpt.max' => 'El extracto no puede tener más de 500 caracteres.',
            'featured_image.image' => 'La imagen destacada debe ser un archivo de imagen (JPG, PNG, etc.).',
            'featured_image.max' => 'La imagen destacada no puede pesar más de 2MB.',
            'published_at.date' => 'La fecha de publicación debe ser una fecha válida.',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = store_image_safely($request->file('featured_image'), 'blog_images');
        }

        if ($request->boolean('published') && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['published'] = $request->boolean('published');
        $data['order'] = (int) ($data['order'] ?? 0);
        if (!isset($data['featured_image_alt'])) {
            $data['featured_image_alt'] = null;
        }

        BlogPost::create($data);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Artículo creado correctamente.');
    }

    public function show(int $id): View
    {
        $blogPost = BlogPost::findOrFail($id);

        return view('admin.blog.show', compact('blogPost'));
    }

    public function edit(int $id): View
    {
        $blogPost = BlogPost::findOrFail($id);
        $updateUrl = url('admin/blog/'.(int) $blogPost->id);

        return view('admin.blog.edit', [
            'blogPost' => $blogPost,
            'updateUrl' => $updateUrl,
            'post' => $blogPost,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $blogPost = BlogPost::findOrFail($id);
        app()->setLocale('es');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'order' => ['nullable', 'integer'],
        ], [
            'title.required' => 'El título del artículo es obligatorio.',
            'featured_image.image' => 'El archivo debe ser una imagen.',
            'featured_image.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        $disk = (config('filesystems.default') === 's3' || (env('AWS_ACCESS_KEY_ID') && env('AWS_SECRET_ACCESS_KEY') && env('AWS_BUCKET'))) ? 's3' : 'public';

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk($disk)->delete($blogPost->featured_image);
            }
            $data['featured_image'] = store_image_safely($request->file('featured_image'), 'blog_images');
        } elseif ($request->boolean('remove_featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk($disk)->delete($blogPost->featured_image);
            }
            $data['featured_image'] = null;
        }

        if ($request->boolean('published') && empty($data['published_at']) && !$blogPost->published_at) {
            $data['published_at'] = now();
        }

        $data['published'] = $request->boolean('published');
        $data['order'] = (int) ($data['order'] ?? $blogPost->order ?? 0);

        $blogPost->update($data);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Artículo actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $blogPost = BlogPost::findOrFail($id);
        $disk = (config('filesystems.default') === 's3' || (env('AWS_ACCESS_KEY_ID') && env('AWS_SECRET_ACCESS_KEY') && env('AWS_BUCKET'))) ? 's3' : 'public';
        if ($blogPost->featured_image) {
            Storage::disk($disk)->delete($blogPost->featured_image);
        }
        $blogPost->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Artículo eliminado correctamente.');
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'posts' => 'required|array',
            'posts.*.id' => 'required|exists:blog_posts,id',
            'posts.*.order' => 'required|integer',
        ]);

        foreach ($request->posts as $postData) {
            BlogPost::where('id', $postData['id'])->update(['order' => $postData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
