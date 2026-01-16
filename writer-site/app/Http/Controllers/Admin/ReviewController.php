<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Listar todas las reseñas
     */
    public function index(): View
    {
        $reviews = Review::with(['user:id,name', 'book:id,title'])
            ->orderBy('approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = Review::where('approved', false)->count();
        $approvedCount = Review::where('approved', true)->count();

        return view('admin.reviews.index', compact('reviews', 'pendingCount', 'approvedCount'));
    }

    /**
     * Aprobar una reseña
     */
    public function approve(Review $review): RedirectResponse
    {
        $review->update(['approved' => true]);

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', 'La reseña se ha aprobado correctamente.');
    }

    /**
     * Rechazar/desaprobar una reseña
     */
    public function reject(Review $review): RedirectResponse
    {
        $review->update(['approved' => false]);

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', 'La reseña se ha rechazado y ya no se mostrará públicamente.');
    }

    /**
     * Eliminar una reseña
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', 'La reseña se ha eliminado correctamente.');
    }
}
