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
        $testimonials = Testimonial::orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }
    
    public function updateOrder(Request $request)
    {
        $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|exists:testimonials,id',
            'testimonials.*.order' => 'required|integer',
        ]);

        foreach ($request->testimonials as $testimonialData) {
            Testimonial::where('id', $testimonialData['id'])->update(['order' => $testimonialData['order']]);
        }

        return response()->json(['success' => true]);
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
        app()->setLocale('es');
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Escribe el nombre de la persona que da el testimonio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'review.required' => 'Escribe el texto del testimonio.',
            'review.max' => 'El texto del testimonio no puede tener más de 2000 caracteres.',
            'rating.required' => 'Selecciona una calificación de 1 a 5 estrellas.',
            'rating.integer' => 'La calificación debe ser un número.',
            'rating.min' => 'La calificación debe ser al menos 1.',
            'rating.max' => 'La calificación no puede ser mayor que 5.',
            'photo.image' => 'La foto debe ser un archivo de imagen (JPG, PNG, etc.).',
            'photo.max' => 'La foto no puede pesar más de 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = store_image_safely($request->file('photo'), 'testimonials');
        }

        $data['active'] = $request->has('active');
        $data['order'] = $request->input('order', 0);

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
        app()->setLocale('es');
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Escribe el nombre de la persona que da el testimonio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'review.required' => 'Escribe el texto del testimonio.',
            'review.max' => 'El texto del testimonio no puede tener más de 2000 caracteres.',
            'rating.required' => 'Selecciona una calificación de 1 a 5 estrellas.',
            'rating.integer' => 'La calificación debe ser un número.',
            'rating.min' => 'La calificación debe ser al menos 1.',
            'rating.max' => 'La calificación no puede ser mayor que 5.',
            'photo.image' => 'La foto debe ser un archivo de imagen (JPG, PNG, etc.).',
            'photo.max' => 'La foto no puede pesar más de 2MB.',
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
