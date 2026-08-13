<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the visitor to Google's consent screen.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Link an existing account or create a new account from Google's identity.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleId = $googleUser->getId();
            $email = $googleUser->getEmail();
            $rawUser = $googleUser->user ?: [];
            $emailVerified = filter_var(
                $rawUser['email_verified'] ?? $rawUser['verified_email'] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );

            if (! $googleId || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $emailVerified) {
                return $this->failed('Google no entregó un correo electrónico verificado.');
            }

            $user = DB::transaction(function () use ($googleId, $email, $googleUser) {
                $user = User::where('google_id', $googleId)->first();

                if ($user) {
                    return $user;
                }

                $user = User::where('email', $email)->first();

                if ($user && $user->google_id && $user->google_id !== $googleId) {
                    throw new \RuntimeException('La cuenta ya está vinculada a otra cuenta de Google.');
                }

                if (! $user) {
                    $user = new User([
                        'name' => $googleUser->getName() ?: $email,
                        'email' => $email,
                        // The current users table requires a password for OAuth-only accounts.
                        'password' => Hash::make(Str::random(64)),
                    ]);
                }

                $user->google_id = $googleId;
                $user->avatar = $googleUser->getAvatar();
                $user->email_verified_at = $user->email_verified_at ?: now();
                $user->save();

                return $user;
            });

            Auth::login($user, true);
            request()->session()->regenerate();

            return redirect('/')->with('status', 'Sesión iniciada con Google.');
        } catch (Throwable $exception) {
            report($exception);

            return $this->failed('No pudimos iniciar sesión con Google. Inténtalo nuevamente.');
        }
    }

    private function failed($message)
    {
        return redirect('/')->with('error', $message);
    }
}
