@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/css/welcome-modern.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="welcome-modern">
        @include('partials.navbar')

        <main>
            <section class="welcome-modern__hero">
                <div class="welcome-modern__container welcome-modern__hero-grid">
                    <div>
                        <div class="welcome-modern__badge">Portal laboral moderno para Chile</div>
                        <h1>Conecta con el <span>talento ideal</span> en menos tiempo.</h1>
                        <p>
                            Publica ofertas laborales, encuentra candidatos calificados y gestiona tus
                            procesos de selección desde una plataforma simple, rápida y moderna.
                        </p>
                        <div class="welcome-modern__hero-actions">
                            <a class="welcome-modern__btn" href="{{ env('PLATFORM_URL').'/offers/create' }}">Publicar oferta gratis</a>
                            <a class="welcome-modern__btn welcome-modern__btn--secondary" href="{{ url('/jobs') }}">Buscar empleos</a>
                        </div>
                    </div>

                    <div class="welcome-modern__hero-card">
                        <h3>Encuentra tu próxima oportunidad</h3>
                        <form class="welcome-modern__search-box" id="welcome-job-search-form">
                            <input type="text" id="job_search" placeholder="Cargo, empresa o palabra clave">
                            <select id="region_search">
                                <option value="">Selecciona región</option>
                                @foreach(App\Region::all() as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            <select id="category_search">
                                <option value="">Categoría</option>
                                @foreach(App\JobCategory::all() as $jobCategory)
                                    <option value="{{ $jobCategory->id }}">{{ $jobCategory->name }}</option>
                                @endforeach
                            </select>
                            <button class="welcome-modern__btn" type="submit">Buscar ahora</button>
                        </form>

                        <div class="welcome-modern__stats">
                            <div class="welcome-modern__stat">
                                <strong>+1K</strong>
                                <span>Ofertas</span>
                            </div>
                            <div class="welcome-modern__stat">
                                <strong>+500</strong>
                                <span>Empresas</span>
                            </div>
                            <div class="welcome-modern__stat">
                                <strong>24/7</strong>
                                <span>Acceso</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="welcome-modern__container">
                    <div class="welcome-modern__section-title">
                        <h2>Todo para contratar mejor</h2>
                        <p>Herramientas diseñadas para empresas que necesitan publicar, filtrar y contactar candidatos de forma más eficiente.</p>
                    </div>

                    <div class="welcome-modern__cards">
                        <div class="welcome-modern__card">
                            <div class="welcome-modern__icon">01</div>
                            <h3>Publica ofertas</h3>
                            <p>Crea avisos laborales claros y visibles para llegar a candidatos activos en todo Chile.</p>
                        </div>

                        <div class="welcome-modern__card">
                            <div class="welcome-modern__icon">02</div>
                            <h3>Filtra candidatos</h3>
                            <p>Encuentra perfiles por experiencia, ubicación, área laboral y disponibilidad.</p>
                        </div>

                        <div class="welcome-modern__card">
                            <div class="welcome-modern__icon">03</div>
                            <h3>Contrata rápido</h3>
                            <p>Optimiza tus procesos con postulaciones centralizadas y contacto directo.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="welcome-modern__jobs">
                <div class="welcome-modern__container">
                    <div class="welcome-modern__section-title">
                        <h2>Ofertas destacadas</h2>
                        <p>Una vista limpia para mostrar oportunidades laborales recientes.</p>
                    </div>

                    <div class="welcome-modern__job-list">
                        @forelse($featuredOffers as $offer)
                            <div class="welcome-modern__job">
                                <div>
                                    <small>
                                        {{ optional($offer->category)->name ?: 'Oferta laboral' }}
                                        ·
                                        {{ optional($offer->region)->name ?: 'Chile' }}
                                    </small>
                                    <h3>{{ $offer->title }}</h3>
                                </div>
                                <a class="welcome-modern__btn" href="{{ 'https://app.encontretrabajo.cl/offers/detail/'.$offer->slug }}">Ver oferta</a>
                            </div>
                        @empty
                            <div class="welcome-modern__job">
                                <div>
                                    <small>Ofertas destacadas</small>
                                    <h3>Pronto mostraremos nuevas oportunidades aquí.</h3>
                                </div>
                                <a class="welcome-modern__btn" href="{{ url('/jobs') }}">Ver empleos</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section>
                <div class="welcome-modern__container">
                    <div class="welcome-modern__section-title">
                        <h2>Planes para empresas</h2>
                        <p>Opciones simples para publicar ofertas y acceder a mejores herramientas de reclutamiento.</p>
                    </div>

                    <div class="welcome-modern__plans">
                        <article class="welcome-modern__plan">
                            <h3>Gratis</h3>
                            <div class="welcome-modern__price">$0</div>
                            <p class="welcome-modern__plan-copy">Ideal para empezar a publicar vacantes y probar la plataforma.</p>
                            <ul>
                                <li>Duración 90 días</li>
                                <li>Visibilidad básica</li>
                            </ul>
                            <a class="welcome-modern__btn welcome-modern__btn--secondary" href="https://app.encontretrabajo.cl/plans/available">Comenzar</a>
                        </article>

                        <article class="welcome-modern__plan welcome-modern__plan--featured">
                            <span class="welcome-modern__plan-badge">Más solicitado</span>
                            <h3>Destacado</h3>
                            <div class="welcome-modern__price">$9.990</div>
                            <p class="welcome-modern__plan-meta">por publicación</p>
                            <p class="welcome-modern__plan-copy">Pensado para empresas que necesitan mayor alcance y más postulaciones calificadas.</p>
                            <ul>
                                <li>Duración 90 días</li>
                                <li>Mayor visibilidad</li>
                            </ul>
                            <a class="welcome-modern__btn" href="https://app.encontretrabajo.cl/plans/available">Elegir plan</a>
                        </article>

                        <article class="welcome-modern__plan">
                            <h3>Emprendedor</h3>
                            <div class="welcome-modern__price">$59.990</div>
                            <p class="welcome-modern__plan-meta">por mes</p>
                            <p class="welcome-modern__plan-copy">Para equipos de selección que requieren volumen, soporte y herramientas extra.</p>
                            <ul>
                                <li>Publicaciones múltiples</li>
                                <li>10 avisos destacados</li>
                                <li>Duración 90 días</li>
                            </ul>
                            <a class="welcome-modern__btn welcome-modern__btn--secondary" href="https://app.encontretrabajo.cl/plans/available">Contactar</a>
                        </article>

                        <article class="welcome-modern__plan">
                            <h3>Empresa</h3>
                            <div class="welcome-modern__price">$260.000</div>
                            <p class="welcome-modern__plan-meta">por año</p>
                            <p class="welcome-modern__plan-copy">Para empresas con procesos de selección continuos, múltiples vacantes o apoyo especializado.</p>
                            <ul>
                                <li>Avisos destacados ilimitados</li>
                                <li>Duración 90 días</li>
                            </ul>
                            <a class="welcome-modern__btn welcome-modern__btn--secondary" href="https://app.encontretrabajo.cl/plans/available">Solicitar plan</a>
                        </article>
                    </div>
                </div>
            </section>

            <section>
                <div class="welcome-modern__container">
                    <div class="welcome-modern__cta">
                        <h2>Empieza a encontrar mejores candidatos hoy.</h2>
                        <a class="welcome-modern__btn welcome-modern__btn--secondary" href="{{ env('PLATFORM_URL').'/offers/create' }}">Publicar una oferta</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="welcome-modern__footer">
            <div class="welcome-modern__container">
                © 2026 Encontré Trabajo. Todos los derechos reservados.
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script>
        function storeWelcomeJobQuery() {
            const jobSearch = document.getElementById('job_search');
            const regionSearch = document.getElementById('region_search');
            const categorySearch = document.getElementById('category_search');

            localStorage.setItem('encontre_trabajo_job_search', jobSearch ? jobSearch.value : '');
            localStorage.setItem('encontre_trabajo_region_search', regionSearch ? regionSearch.value : '');
            localStorage.setItem('encontre_trabajo_category_search', categorySearch ? categorySearch.value : '');
            localStorage.removeItem('encontre_trabajo_commune_search');

            window.location.href = "{{ url('/jobs') }}";
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('welcome-job-search-form');

            localStorage.removeItem('encontre_trabajo_commune_search');

            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    storeWelcomeJobQuery();
                });
            }
        });
    </script>
@endpush
