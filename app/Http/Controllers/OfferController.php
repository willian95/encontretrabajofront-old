<?php

namespace App\Http\Controllers;

use App\Commune;
use App\JobCategory;
use App\Offer;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::check()) {
            return redirect()->route('google.redirect')
                ->with('status', 'Inicia sesión para publicar una oferta.');
        }

        $data = $request->validate([
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

        $data['user_id'] = Auth::id();
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
