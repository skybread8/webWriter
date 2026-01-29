<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReaderPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReaderPhotoController extends Controller
{
    /**
     * Listar solo fotos generales (sin libro específico)
     */
    public function index(): View
    {
        $photos = ReaderPhoto::whereNull('book_id')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reader-photos.index', compact('photos'));
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*.id' => 'required|exists:reader_photos,id',
            'photos.*.order' => 'required|integer',
        ]);

        foreach ($request->photos as $photoData) {
            ReaderPhoto::where('id', $photoData['id'])->update(['order' => $photoData['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mostrar formulario para crear foto general (sin libro)
     */
    public function create(): View
    {
        return view('admin.reader-photos.create');
    }

    /**
     * Guardar nueva foto
     */
    public function store(Request $request): RedirectResponse
    {
        app()->setLocale('es');
        $data = $request->validate([
            'book_id' => ['nullable', 'exists:books,id'],
            'photo' => ['required', 'image', 'max:4096'],
            'photo_alt' => ['nullable', 'string', 'max:255'],
            'reader_name' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:500'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'book_id.exists' => 'El libro seleccionado no existe.',
            'photo.required' => 'Debes subir una foto.',
            'photo.image' => 'El archivo debe ser una imagen (JPG, PNG, etc.).',
            'photo.max' => 'La foto no puede pesar más de 4MB.',
            'reader_name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'caption.max' => 'La descripción no puede tener más de 500 caracteres.',
        ]);

        // Si viene desde la página de fotos generales, asegurar que book_id sea null
        if ($request->input('book_id') === '' || $request->input('book_id') === null) {
            $data['book_id'] = null;
        } else {
            // Asegurar que book_id se guarde como integer
            $data['book_id'] = (int) $request->input('book_id');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = store_image_safely($request->file('photo'), 'readers');
        }

        $data['active'] = $request->has('active');
        $data['order'] = $request->input('order', 0);

        $photo = ReaderPhoto::create($data);

        // Si la foto pertenece a un libro, redirigir a la edición del libro
        if ($photo->book_id) {
            return redirect()
                ->route('admin.books.edit', $photo->book_id)
                ->with('status', 'Foto de lector creada correctamente.');
        }

        // Si no, redirigir a la lista de fotos generales
        return redirect()
            ->route('admin.reader-photos.index')
            ->with('status', 'Foto de lector creada correctamente.');
    }

    /**
     * Mostrar formulario para editar foto
     */
    public function edit(ReaderPhoto $readerPhoto): View
    {
        // Cargar la relación del libro si existe
        if ($readerPhoto->book_id) {
            $readerPhoto->load('book');
        }
        return view('admin.reader-photos.edit', compact('readerPhoto'));
    }

    /**
     * Actualizar foto
     */
    public function update(Request $request, ReaderPhoto $readerPhoto): RedirectResponse
    {
        app()->setLocale('es');
        $data = $request->validate([
            'book_id' => ['nullable', 'exists:books,id'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'photo_alt' => ['nullable', 'string', 'max:255'],
            'reader_name' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:500'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'book_id.exists' => 'El libro seleccionado no existe.',
            'photo.image' => 'El archivo debe ser una imagen (JPG, PNG, etc.).',
            'photo.max' => 'La foto no puede pesar más de 4MB.',
            'reader_name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'caption.max' => 'La descripción no puede tener más de 500 caracteres.',
        ]);

        // Si viene vacío, asegurar que book_id sea null (para fotos generales)
        if ($request->input('book_id') === '' || $request->input('book_id') === null) {
            $data['book_id'] = null;
        }

        if ($request->hasFile('photo')) {
            // Eliminar foto anterior si existe
            if ($readerPhoto->photo) {
                Storage::disk(config('filesystems.default') === 's3' ? 's3' : 'public')->delete($readerPhoto->photo);
            }
            $data['photo'] = store_image_safely($request->file('photo'), 'readers');
        }

        $data['active'] = $request->has('active');

        $readerPhoto->update($data);

        // Si la foto pertenece a un libro, redirigir a la edición del libro
        if ($readerPhoto->book_id) {
            return redirect()
                ->route('admin.books.edit', $readerPhoto->book_id)
                ->with('status', 'Foto de lector actualizada correctamente.');
        }

        // Si no, redirigir a la lista de fotos generales
        return redirect()
            ->route('admin.reader-photos.index')
            ->with('status', 'Foto de lector actualizada correctamente.');
    }

    /**
     * Eliminar foto
     */
    public function destroy(ReaderPhoto $readerPhoto): RedirectResponse
    {
        // Guardar el book_id antes de eliminar
        $bookId = $readerPhoto->book_id;

        // Eliminar foto si existe
        if ($readerPhoto->photo) {
            Storage::disk(config('filesystems.default') === 's3' ? 's3' : 'public')->delete($readerPhoto->photo);
        }

        $readerPhoto->delete();

        // Si la foto pertenecía a un libro, redirigir a la edición del libro
        if ($bookId) {
            return redirect()
                ->route('admin.books.edit', $bookId)
                ->with('status', 'Foto de lector eliminada correctamente.');
        }

        // Si no, redirigir a la lista de fotos generales
        return redirect()
            ->route('admin.reader-photos.index')
            ->with('status', 'Foto de lector eliminada correctamente.');
    }
}
