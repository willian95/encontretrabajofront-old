@extends('layouts.main')

@push('css')
    <style>
        .offer-verification { padding: 130px 0 60px; }
        .offer-verification__card { border: 0; border-radius: 14px; box-shadow: 0 12px 35px rgba(15, 23, 42, .12); }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <main class="offer-verification">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card offer-verification__card">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="h3 mb-2">Confirma tu correo</h1>
                            <p class="text-muted">Enviamos un código de seis dígitos a <strong>{{ $email }}</strong>. Ingresa el código para crear tu cuenta de empresa y publicar la oferta.</p>

                            <form method="POST" action="{{ route('offers.verify-email.confirm') }}" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label for="code">Código de verificación</label>
                                    <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" class="form-control @error('code') is-invalid @enderror" required autofocus autocomplete="one-time-code">
                                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Verificar y publicar oferta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
