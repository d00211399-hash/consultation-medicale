<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        // Seul un administrateur peut réinitialiser, et jamais un compte admin
        abort_unless($request->user()?->role === 'admin', 403);
        abort_if($user->role === 'admin', 403);

        $password = Str::random(10);

        $user->forceFill([
            'password'             => Hash::make($password),
            'must_change_password' => true,
            'temp_password'        => $password, // Stocker le mot de passe temporaire en clair
        ])->save();

        return back()
            ->with('success', 'Mot de passe réinitialisé.')
            ->with('generated_email', $user->email)
            ->with('generated_password', $password);
    }
}
