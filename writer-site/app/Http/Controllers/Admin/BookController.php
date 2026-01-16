<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('admin.books.index', compact('books'));
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.id' => 'required|exists:books,id',
            'books.*.order' => 'required|integer',
        ]);

        foreach ($request->books as $bookData) {
            Book::where('id', $bookData['id'])->update(['order' => $bookData['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        app()->setLocale('es');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'stripe_price_id' => ['nullable', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'Escribe un título para el libro.',
            'title.max' => 'El título no puede tener más de 255 caracteres.',
            'description.required' => 'Añade una descripción breve; aparecerá en la lista de libros.',
            'description.max' => 'La descripción no puede tener más de 500 caracteres.',
            'price.required' => 'Indica un precio para poder vender el libro.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',
            'cover_image.image' => 'La imagen de portada debe ser un archivo de imagen (JPG, PNG, etc.).',
            'cover_image.max' => 'La imagen de portada no puede pesar más de 4MB.',
        ]);

        if ($request->hasFile('cover_image')) {
            ensure_storage_directories();
            $data['cover_image'] = store_image_safely($request->file('cover_image'), 'covers');
        }

        $data['active'] = $request->boolean('active', true);
        $data['order'] = $request->input('order', 0);

        Book::create($data);

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'El libro se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $readerPhotos = $book->readerPhotos()->orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('admin.books.edit', compact('book', 'readerPhotos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        app()->setLocale('es');
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'stripe_price_id' => ['nullable', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('cover_image')) {
            ensure_storage_directories();
            $data['cover_image'] = store_image_safely($request->file('cover_image'), 'covers');
        }

        $data['active'] = $request->boolean('active', false);

        $book->update($data);

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'El libro se ha actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'El libro se ha eliminado.');
    }
}
