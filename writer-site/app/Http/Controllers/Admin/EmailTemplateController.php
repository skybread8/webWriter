<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    public function index(): View
    {
        app()->setLocale('es');
        $templates = EmailTemplate::orderBy('name')->get();

        return view('admin.email-templates.index', compact('templates'));
    }

    public function edit(EmailTemplate $emailTemplate): View
    {
        app()->setLocale('es');

        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate): RedirectResponse
    {
        app()->setLocale('es');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre del template es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'subject.required' => 'El asunto del correo es obligatorio.',
            'subject.max' => 'El asunto no puede tener más de 255 caracteres.',
            'body.required' => 'El cuerpo del correo es obligatorio.',
        ]);

        $data['active'] = $request->has('active');

        $emailTemplate->update($data);

        return redirect()
            ->route('admin.email-templates.index')
            ->with('status', 'Template de correo actualizado correctamente.');
    }
}
