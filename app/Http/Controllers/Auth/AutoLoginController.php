<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AutoLoginController extends Controller
{
    /**
     * Handle auto login via token
     */
    public function login(Request $request, string $token)
    {
        // Find user by auto login token
        $user = User::where('auto_login_token', $token)
                   ->where('auto_login_expires_at', '>', now())
                   ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Link de acesso inválido ou expirado.');
        }

        // Check if user is a client
        if ($user->role !== 'client') {
            return redirect()->route('login')->with('error', 'Acesso não autorizado.');
        }

        // Login user
        Auth::login($user);

        // Clear the auto login token for security
        $user->update([
            'auto_login_token' => null,
            'auto_login_expires_at' => null,
        ]);

        // Redirect to client dashboard with welcome message
        return redirect()->route('client.dashboard')->with('success', 'Bem-vindo! Você foi logado automaticamente.');
    }

    /**
     * Generate auto login token for user
     */
    public static function generateAutoLoginToken(User $user): string
    {
        $token = Hash::make($user->email . now()->timestamp . rand(1000, 9999));
        $token = str_replace(['/', '+', '='], ['_', '-', ''], base64_encode($token));
        
        // Set token expiration (24 hours)
        $user->update([
            'auto_login_token' => $token,
            'auto_login_expires_at' => now()->addHours(24),
        ]);

        return $token;
    }
}
