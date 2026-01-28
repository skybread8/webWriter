<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('order')->orderBy('created_at', 'asc')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        app()->setLocale('es');

        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'question.required' => 'Escribe la pregunta.',
            'question.max' => 'La pregunta no puede tener más de 255 caracteres.',
            'answer.string' => 'La respuesta debe ser texto.',
            'order.integer' => 'El orden debe ser un número entero.',
            'order.min' => 'El orden no puede ser negativo.',
        ]);

        $data['active'] = $request->has('active');
        $data['order'] = $request->input('order', 0);

        Faq::create($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'Pregunta frecuente creada correctamente.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        app()->setLocale('es');

        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'question.required' => 'Escribe la pregunta.',
            'question.max' => 'La pregunta no puede tener más de 255 caracteres.',
            'answer.string' => 'La respuesta debe ser texto.',
            'order.integer' => 'El orden debe ser un número entero.',
            'order.min' => 'El orden no puede ser negativo.',
        ]);

        $data['active'] = $request->has('active');

        $faq->update($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'Pregunta frecuente actualizada correctamente.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'Pregunta frecuente eliminada correctamente.');
    }
}

