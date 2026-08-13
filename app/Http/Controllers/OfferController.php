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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        } else {
            if (User::where('email', $data['email'])->exists()) {
                return back()->withErrors(['email' => 'Ya existe una cuenta con este correo.'])->withInput();
            }

            $user = User::create([
                'name' => $data['company_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => 3,
            ]);

            Auth::login($user);
            $request->session()->regenerate();
        }

        unset($data['account_mode'], $data['email'], $data['password'], $data['password_confirmation'], $data['company_name']);

        $data['user_id'] = $user->id;
        $data['status'] = 'abierto';
        $data['min_wage'] = (int) $data['wage_type'] === 1 ? $data['min_wage'] : null;
        $data['max_wage'] = null;
        $data['description'] = nl2br(e($data['description']));
        $data['slug'] = $this->uniqueSlug($data['title']);

        $offer = Offer::create($data);

        return redirect('/jobs/'.$offer->slug)
            ->with('status', 'Tu oferta fue publicada correctamente.');
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
