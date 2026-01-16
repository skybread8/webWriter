<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Guardar o actualizar una reseña
     */
    public function store(Request $request, string $locale, Book $book): RedirectResponse
    {
        app()->setLocale('es');
        
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ], [
            'rating.required' => 'Debes seleccionar una valoración de 1 a 10 estrellas.',
            'rating.integer' => 'La valoración debe ser un número.',
            'rating.min' => 'La valoración debe ser al menos 1 estrella.',
            'rating.max' => 'La valoración no puede ser mayor que 10 estrellas.',
            'comment.max' => 'El comentario no puede tener más de 2000 caracteres.',
        ]);

        // Buscar si ya existe una reseña del usuario para este libro
        $review = Review::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($review) {
            // Actualizar reseña existente (vuelve a pendiente de aprobación si se modifica)
            $review->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'approved' => false, // Vuelve a pendiente de aprobación
            ]);
            $message = 'Tu reseña se ha actualizado y está pendiente de aprobación.';
        } else {
            // Crear nueva reseña (pendiente de aprobación)
            Review::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'approved' => false, // Pendiente de aprobación
            ]);
            $message = 'Tu reseña se ha enviado y está pendiente de aprobación.';
        }

        return redirect()
            ->to(localized_route('books.show', $book))
            ->with('status', $message);
    }

    /**
     * Eliminar una reseña
     */
    public function destroy(string $locale, Review $review): RedirectResponse
    {
        // Verificar que la reseña pertenece al usuario autenticado
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $book = $review->book;
        $review->delete();

        return redirect()
            ->to(localized_route('books.show', $book))
            ->with('status', 'Tu reseña se ha eliminado correctamente.');
    }
}
