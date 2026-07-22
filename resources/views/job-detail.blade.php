@extends('layouts.main')

@php
    $shareDescription = preg_replace('/\s+/', ' ', strip_tags((string) $offer->description));
    $shareDescription = mb_substr(trim($shareDescription), 0, 160);
    $shareImage = optional($offer->user)->image ?: asset('assets/img/logo-color.png');
@endphp

@push('meta')
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_CL">
    <meta property="og:site_name" content="Encontré Trabajo">
    <meta property="og:title" content="{{ $offer->title }} | Encontré Trabajo">
    <meta property="og:description" content="{{ $shareDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:alt" content="{{ $offer->title }}">
@endpush

@push('css')
    <style>
        .job-detail { padding: 120px 0 50px; background: #f6f8fb; min-height: 100vh; }
        .job-detail__card { border: 0; border-radius: 12px; box-shadow: 0 8px 28px rgba(0, 0, 0, .08); }
        .job-detail__company-image { width: 90px; height: 90px; object-fit: cover; border-radius: 50%; }
        .job-detail__title { color: #1675a9; }
        .job-detail__description img { max-width: 100%; height: auto; }
        .job-detail__description ul { padding-left: 1.4rem; }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <main class="job-detail">
        <div class="container">
            <div class="row justify-content-center">
                <section class="col-lg-10 col-xl-11 mb-4">
                    <article class="card job-detail__card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                @if(optional($offer->user)->image)
                                    <img class="job-detail__company-image mr-3" src="{{ $offer->user->image }}" alt="{{ optional($offer->user)->business_name ?: 'Empresa' }}">
                                @endif
                                <div>
                                    <h1 class="h3 job-detail__title mb-1">{{ $offer->title }}</h1>
                                    <p class="mb-0 text-muted">{{ optional($offer->user)->business_name }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6 mb-2"><strong>Puesto:</strong> {{ $offer->job_position }}</div>
                                <div class="col-sm-6 mb-2"><strong>Categoría:</strong> {{ optional($offer->category)->name ?: 'Sin categoría' }}</div>
                                <div class="col-sm-6 mb-2"><strong>Ubicación:</strong> {{ optional($offer->region)->name }}{{ $offer->commune ? ', '.$offer->commune->name : '' }}{{ $offer->address ? ', '.$offer->address : '' }}</div>
                                <div class="col-sm-6 mb-2"><strong>Renta:</strong> @if($offer->wage_type == 1) $ {{ number_format($offer->min_wage, 0, ',', '.') }} {{ $offer->extra_wage }} @else A convenir @endif</div>
                            </div>

                            <hr>
                            <h2 class="h5 mt-4">Descripción</h2>
                            <div class="job-detail__description">{!! $offer->description !!}</div>

                            <div class="mt-4">
                                <a href="{{ 'https://app.encontretrabajo.cl/offers/detail/'.$offer->slug }}" class="btn btn-primary">Postular</a>
                                <a href="{{ url('/jobs') }}" class="btn btn-outline-secondary ml-2">Volver a ofertas</a>
                            </div>
                        </div>
                    </article>
                </section>

                <aside class="col-lg-10 col-xl-11">
                    @include('partials.ads-sidebar')
                </aside>
            </div>
        </div>
    </main>
@endsection
