<header class="shared-navbar">
    <div class="shared-navbar__container">
        <a class="shared-navbar__brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/Logo-footer-color.png') }}" alt="Encontré Trabajo">
        </a>

        <nav class="shared-navbar__menu">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ url('/jobs') }}">Buscar empleos</a>
            <a href="{{ url('/recruitment') }}">Reclutamiento y selección</a>
            <a class="shared-navbar__btn" href="https://app.encontretrabajo.cl/register">Crear cuenta</a>
        </nav>
    </div>
</header>
