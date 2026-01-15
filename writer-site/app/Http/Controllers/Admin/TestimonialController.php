<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Listar todos los testimonios
     */
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Mostrar formulario para crear testimonio
     */
    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    /**
     * Guardar nuevo testimonio
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'active' => ['boolean'],
        ], [
            'name.required' => 'Escribe el nombre de la persona que da el testimonio.',
            'review.required' => 'Escribe el texto del testimonio.',
            'rating.required' => 'Selecciona una calificación de 1 a 5 estrellas.',
            'photo.image' => 'La foto debe ser una imagen válida.',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['active'] = $request->has('active');

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonio creado correctamente.');
    }

    /**
     * Mostrar formulario para editar testimonio
     */
    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Actualizar testimonio
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'active' => ['boolean'],
        ], [
            'name.required' => 'Escribe el nombre de la persona que da el testimonio.',
            'review.required' => 'Escribe el texto del testimonio.',
            'rating.required' => 'Selecciona una calificación de 1 a 5 estrellas.',
            'photo.image' => 'La foto debe ser una imagen válida.',
        ]);

        if ($request->hasFile('photo')) {
            // Eliminar foto anterior si existe
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['active'] = $request->has('active');

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonio actualizado correctamente.');
    }

    /**
     * Eliminar testimonio
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        // Eliminar foto si existe
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonio eliminado correctamente.');
    }
}
