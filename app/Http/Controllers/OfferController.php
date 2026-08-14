<?php

namespace App\Http\Controllers;

use App\Commune;
use App\JobCategory;
use App\Offer;
use App\Region;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class OfferController extends Controller
{
    public function create()
    {
        return view('offers.create', [
            'categories' => JobCategory::orderBy('name')->get(),
            'regions' => Region::orderBy('name')->get(),
            'expirationDate' => Carbon::today()->addDays(30)->format('Y-m-d'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'account_mode' => ['required', 'in:login,register'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'company_name' => ['nullable', 'required_if:account_mode,register', 'string', 'max:255'],
            'password_confirmation' => ['nullable', 'required_if:account_mode,register', 'same:password'],
            'captcha' => ['required', 'string'],
            'title' => ['required', 'string', 'max:150'],
            'job_position' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'integer', 'exists:job_categories,id'],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'commune_id' => ['nullable', 'integer', 'exists:communes,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'wage_type' => ['required', 'boolean'],
            'min_wage' => ['nullable', 'numeric', 'min:0'],
            'extra_wage' => ['nullable', 'string', 'max:100'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        if (! $this->captchaIsValid($request, $data['captcha'])) {
            return back()->withErrors(['captcha' => 'El CAPTCHA no es válido o ya venció.'])->withInput();
        }

        if ($data['commune_id'] && !Commune::where('id', $data['commune_id'])
            ->where('region_id', $data['region_id'])->exists()) {
            return back()->withErrors(['commune_id' => 'La comuna no pertenece a la región seleccionada.'])->withInput();
        }

        if ((int) $data['wage_type'] === 1 && empty($data['min_wage'])) {
            return back()->withErrors(['min_wage' => 'Indica la renta ofrecida.'])->withInput();
        }

        if ($data['account_mode'] === 'login') {
            if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return back()->withErrors(['email' => 'El correo o la contraseña no son válidos.'])->withInput();
            }

            $request->session()->regenerate();
            $user = Auth::user();
            $offer = $this->createOffer($this->offerData($data), $user->id);

            return redirect('/jobs/'.$offer->slug)
                ->with('status', 'Tu oferta fue publicada correctamente.');
        }

        if (User::where('email', $data['email'])->exists()) {
            return back()->withErrors(['email' => 'Ya existe una cuenta con este correo.'])->withInput();
        }

        $verificationCode = (string) random_int(100000, 999999);
        $request->session()->put('pending_offer_registration', [
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'offer' => $this->offerData($data),
            'code' => Hash::make($verificationCode),
            'expires_at' => now()->addMinutes(15)->timestamp,
        ]);

        try {
            Mail::raw(
                'Tu código para confirmar el correo y publicar la oferta es: '.$verificationCode.
                '. Este código vence en 15 minutos.',
                function ($message) use ($data) {
                    $message->to($data['email'], $data['company_name'])
                        ->subject('Confirma tu correo electrónico');
                }
            );
        } catch (Throwable $exception) {
            report($exception);
            $request->session()->forget('pending_offer_registration');

            return back()->withErrors(['email' => 'No fue posible enviar el código de verificación. Inténtalo nuevamente.'])->withInput();
        }

        return redirect()->route('offers.verify-email')
            ->with('status', 'Enviamos un código de verificación a tu correo electrónico.');
    }

    public function captcha(Request $request)
    {
        $left = random_int(1, 9);
        $right = random_int(1, 9);
        $answer = (string) ($left + $right);

        $request->session()->put('offer_captcha', [
            'answer' => Hash::make($answer),
            'expires_at' => now()->addMinutes(5)->timestamp,
        ]);

        $text = $left.' + '.$right.' = ?';
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="180" height="52" viewBox="0 0 180 52">'
            .'<rect width="180" height="52" rx="6" fill="#edf2f7"/>'
            .'<path d="M8 12L170 39M20 43L151 8" stroke="#cbd5e0" stroke-width="2"/>'
            .'<text x="90" y="34" text-anchor="middle" font-family="monospace" font-size="24" fill="#1a202c">'.$text.'</text>'
            .'</svg>';

        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function showEmailVerification(Request $request)
    {
        if (! $request->session()->has('pending_offer_registration')) {
            return redirect()->route('offers.create');
        }

        return view('offers.verify-email', [
            'email' => $request->session()->get('pending_offer_registration.email'),
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $pending = $request->session()->get('pending_offer_registration');

        if (! $pending || ($pending['expires_at'] ?? 0) < now()->timestamp) {
            $request->session()->forget('pending_offer_registration');

            return redirect()->route('offers.create')
                ->with('error', 'El código venció. Completa nuevamente el formulario.');
        }

        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        if (! Hash::check($data['code'], $pending['code'])) {
            return back()->withErrors(['code' => 'El código ingresado no es válido.']);
        }

        if (User::where('email', $pending['email'])->exists()) {
            $request->session()->forget('pending_offer_registration');

            return redirect()->route('offers.create')
                ->with('error', 'Ya existe una cuenta con este correo. Inicia sesión para publicar.');
        }

        $offer = DB::transaction(function () use ($pending) {
            $user = User::create([
                'name' => $pending['company_name'],
                'email' => $pending['email'],
                'password' => $pending['password'],
                'role_id' => 3,
                'email_verified_at' => now(),
            ]);

            return $this->createOffer($pending['offer'], $user->id);
        });

        $user = $offer->user;
        Auth::login($user);
        $request->session()->forget('pending_offer_registration');
        $request->session()->regenerate();

        return redirect('/jobs/'.$offer->slug)
            ->with('status', 'Tu correo fue verificado y la oferta fue publicada correctamente.');
    }

    private function captchaIsValid(Request $request, $answer)
    {
        $captcha = $request->session()->pull('offer_captcha');

        return $captcha
            && ($captcha['expires_at'] ?? 0) >= now()->timestamp
            && Hash::check($answer, $captcha['answer']);
    }

    private function offerData(array $data)
    {
        unset($data['account_mode'], $data['email'], $data['password'], $data['password_confirmation'], $data['company_name'], $data['captcha']);

        $data['status'] = 'abierto';
        $data['min_wage'] = (int) $data['wage_type'] === 1 ? $data['min_wage'] : null;
        $data['max_wage'] = null;
        $data['description'] = nl2br(e($data['description']));

        return $data;
    }

    private function createOffer(array $data, $userId)
    {
        $data['user_id'] = $userId;
        $data['slug'] = $this->uniqueSlug($data['title']);

        return Offer::create($data);
    }

    private function uniqueSlug($title)
    {
        $base = Str::slug($title) ?: 'oferta';
        $slug = $base;
        $suffix = 2;

        while (Offer::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
