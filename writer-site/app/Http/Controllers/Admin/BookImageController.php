<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookImageController extends Controller
{
    /**
     * Guardar nueva imagen del libro
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        app()->setLocale('es');
        $data = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'image.required' => 'Debes subir una imagen.',
            'image.image' => 'El archivo debe ser una imagen (JPG, PNG, etc.).',
            'image.max' => 'La imagen no puede pesar más de 4MB.',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = store_image_safely($request->file('image'), 'books');
        }

        $data['order'] = $request->input('order', $book->images()->max('order') + 1 ?? 0);

        $book->images()->create($data);

        return redirect()
            ->route('admin.books.edit', $book)
            ->with('status', 'Imagen del libro añadida correctamente.');
    }

    /**
     * Eliminar imagen del libro
     */
    public function destroy(Book $book, BookImage $bookImage): RedirectResponse
    {
        app()->setLocale('es');
        
        $bookImage->delete();

        return redirect()
            ->route('admin.books.edit', $book)
            ->with('status', 'Imagen eliminada correctamente.');
    }

    /**
     * Actualizar orden de las imágenes
     */
    public function updateOrder(Request $request, Book $book): RedirectResponse
    {
        app()->setLocale('es');
        
        $request->validate([
            'images' => ['required', 'array'],
            'images.*.id' => ['required', 'exists:book_images,id'],
            'images.*.order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->input('images') as $imageData) {
            $book->images()
                ->where('id', $imageData['id'])
                ->update(['order' => $imageData['order']]);
        }

        return redirect()
            ->route('admin.books.edit', $book)
            ->with('status', 'Orden de imágenes actualizado correctamente.');
    }
}
