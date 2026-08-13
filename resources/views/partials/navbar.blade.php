<header class="shared-navbar">
    <div class="shared-navbar__container">
        <a class="shared-navbar__brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/Logo-footer-color.png') }}" alt="Encontré Trabajo">
        </a>

        <nav class="shared-navbar__menu">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ url('/jobs') }}">Buscar empleos</a>
            <a href="{{ route('offers.create') }}">Publicar oferta</a>
            <a href="{{ url('/recruitment') }}">Reclutamiento y selección</a>
            <a class="shared-navbar__btn" href="https://app.encontretrabajo.cl/register">Crear cuenta</a>
            <a class="shared-navbar__btn shared-navbar__btn--google" href="{{ route('google.redirect') }}">
                <i class="fa fa-google" aria-hidden="true"></i> Continuar con Google
            </a>
        </nav>
    </div>

    @if (session('status') || session('error'))
        <div class="shared-navbar__notice {{ session('error') ? 'shared-navbar__notice--error' : '' }}" role="status">
            {{ session('error') ?: session('status') }}
        </div>
    @endif
</header>
