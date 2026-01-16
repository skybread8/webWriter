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
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'order' => ['nullable', 'integer'],
        ], [
            'title.required' => 'El título del artículo es obligatorio.',
            'title.max' => 'El título no puede tener más de 255 caracteres.',
            'slug.max' => 'El slug no puede tener más de 255 caracteres.',
            'slug.unique' => 'Este slug ya está en uso. Elige otro.',
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

        BlogPost::create($data);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Artículo creado correctamente.');
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        app()->setLocale('es');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug,' . $blogPost->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'order' => ['nullable', 'integer'],
        ], [
            'title.required' => 'El título del artículo es obligatorio.',
            'slug.unique' => 'Este slug ya está en uso.',
            'featured_image.image' => 'El archivo debe ser una imagen.',
            'featured_image.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        } elseif ($request->boolean('remove_featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $data['featured_image'] = null;
        }

        if ($request->boolean('published') && empty($data['published_at']) && !$blogPost->published_at) {
            $data['published_at'] = now();
        }

        $blogPost->update($data);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Artículo actualizado correctamente.');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
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
