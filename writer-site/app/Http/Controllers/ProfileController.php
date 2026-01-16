<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's account dashboard.
     */
    public function index(string $locale): View
    {
        $user = auth()->user();
        $ordersCount = $user->orders()->count();
        $recentOrders = $user->orders()->latest()->take(3)->get();

        return view('account.dashboard', compact('user', 'ordersCount', 'recentOrders'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(string $locale): View
    {
        return view('account.profile', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, string $locale): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->to(localized_route('account.profile'))
            ->with('status', 'Tu perfil se ha actualizado correctamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, string $locale): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to(localized_route('home'))
            ->with('status', 'Tu cuenta ha sido eliminada correctamente.');
    }
}
