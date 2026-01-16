<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function editAbout()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'about'],
            ['title' => 'Sobre el autor', 'content' => null]
        );

        return view('admin.pages.about', compact('page'));
    }

    public function updateAbout(Request $request)
    {
        $page = Page::where('slug', 'about')->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ], [
            'title.required' => 'Este título se muestra en la página "Sobre el autor".',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = store_image_safely($request->file('image'), 'author');
        }

        $page->update($data);

        return redirect()
            ->route('admin.pages.about.edit')
            ->with('status', 'La página "Sobre el autor" se ha guardado.');
    }

    public function editContact()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'contact'],
            ['title' => 'Contacto', 'content' => null]
        );

        return view('admin.pages.contact', compact('page'));
    }

    public function updateContact(Request $request)
    {
        $page = Page::where('slug', 'contact')->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ], [
            'title.required' => 'Este título se muestra en la página de contacto.',
        ]);

        $page->update($data);

        return redirect()
            ->route('admin.pages.contact.edit')
            ->with('status', 'La página de contacto se ha guardado.');
    }
}
