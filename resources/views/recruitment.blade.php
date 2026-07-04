@extends('layouts.main')

@push('css')
    <style>
        .recruitment-page {
            --recruitment-blue: #38bdf8;
            --recruitment-blue-dark: #0284c7;
            --recruitment-blue-deep: #1d4ed8;
            --recruitment-blue-soft: #e0f2fe;
            --recruitment-blue-pale: #f0f9ff;
            --recruitment-accent: #14b8a6;
            --recruitment-accent-soft: #ccfbf1;
            --recruitment-light: #f8fafc;
            --recruitment-text: #0f172a;
            --recruitment-muted: #64748b;
            --recruitment-line: #e2e8f0;
            --recruitment-white: #ffffff;
            --recruitment-shadow: 0 20px 50px rgba(15, 23, 42, 0.06);
            background: var(--recruitment-white);
            color: var(--recruitment-text);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .recruitment-page * {
            box-sizing: border-box;
        }

        .recruitment-container {
            width: min(1248px, calc(100% - 48px));
            margin: 0 auto;
        }

        .recruitment-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            padding: 16px 24px;
            font-weight: 800;
            font-size: 16px;
            line-height: 1;
            transition: 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .recruitment-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .recruitment-btn.small {
            padding: 14px 18px;
            font-size: 14px;
        }

        .recruitment-btn--primary {
            background: linear-gradient(135deg, var(--recruitment-blue-dark), var(--recruitment-blue));
            color: #fff;
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
        }

        .recruitment-btn--secondary {
            background: var(--recruitment-white);
            color: var(--recruitment-blue-dark);
            border-color: var(--recruitment-blue-soft);
        }

        .recruitment-btn--ghost {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.18);
        }

        .recruitment-hero {
            background:
                radial-gradient(circle at 82% 18%, rgba(20, 184, 166, 0.14), transparent 24%),
                radial-gradient(circle at 18% 12%, rgba(125, 211, 252, 0.42), transparent 30%),
                linear-gradient(135deg, #0f172a 0%, #1d4ed8 48%, #0ea5e9 100%);
            color: #fff;
            padding: 86px 0 96px;
            overflow: hidden;
        }

        .recruitment-hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 78px;
            align-items: center;
        }

        .recruitment-eyebrow {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.02em;
        }

        .recruitment-eyebrow.dark {
            background: var(--recruitment-blue-soft);
            color: var(--recruitment-blue-dark);
        }

        .recruitment-page h1,
        .recruitment-page h2,
        .recruitment-page h3,
        .recruitment-page p {
            margin-top: 0;
        }

        .recruitment-page h1 {
            font-size: 68px;
            line-height: 1.03;
            letter-spacing: -0.055em;
            margin: 26px 0;
            max-width: 760px;
        }

        .recruitment-page h2 {
            font-size: 46px;
            line-height: 1.1;
            letter-spacing: -0.035em;
            margin-bottom: 18px;
        }

        .recruitment-page h3 {
            font-size: 23px;
            letter-spacing: -0.02em;
        }

        .recruitment-hero p {
            font-size: 22px;
            line-height: 1.55;
            max-width: 660px;
            color: rgba(255, 255, 255, 0.9);
        }

        .recruitment-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 36px;
        }

        .recruitment-hero-panel {
            position: relative;
            background: #fff;
            color: var(--recruitment-text);
            border-radius: 30px;
            padding: 38px;
            min-height: 430px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
            border: 1px solid var(--recruitment-line);
        }

        .recruitment-panel-badge {
            display: inline-flex;
            border-radius: 999px;
            padding: 9px 14px;
            background: var(--recruitment-blue-soft);
            color: var(--recruitment-blue-dark);
            font-size: 13px;
            font-weight: 900;
        }

        .recruitment-hero-panel h2 {
            font-size: 34px;
            margin-top: 24px;
            color: var(--recruitment-blue-dark);
        }

        .recruitment-check-list {
            display: grid;
            gap: 16px;
            margin-top: 30px;
        }

        .recruitment-check-list div {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--recruitment-blue-pale);
            border-radius: 14px;
            padding: 16px;
            font-weight: 800;
        }

        .recruitment-check-list span {
            width: 20px;
            height: 20px;
            border-radius: 999px;
            background: var(--recruitment-blue);
            flex: 0 0 auto;
        }

        .recruitment-quick-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: -54px;
            position: relative;
            z-index: 3;
        }

        .recruitment-quick-stats article,
        .recruitment-plan-card,
        .recruitment-steps-grid article,
        .recruitment-associated-grid article,
        .recruitment-terms-grid article,
        .recruitment-note-card {
            background: #fff;
            border: 1px solid var(--recruitment-line);
            box-shadow: var(--recruitment-shadow);
            border-radius: 24px;
        }

        .recruitment-quick-stats article {
            padding: 28px;
        }

        .recruitment-quick-stats strong {
            display: block;
            font-size: 30px;
            color: var(--recruitment-blue-dark);
            letter-spacing: -0.03em;
        }

        .recruitment-quick-stats span {
            display: block;
            color: var(--recruitment-muted);
            line-height: 1.45;
            margin-top: 8px;
        }

        .recruitment-section {
            padding: 96px 0;
        }

        .recruitment-plans-section,
        .recruitment-terms-section {
            background: var(--recruitment-light);
        }

        .recruitment-section-heading {
            max-width: 820px;
            margin-bottom: 56px;
        }

        .recruitment-section-heading.compact {
            margin-bottom: 40px;
        }

        .recruitment-section-heading h2 {
            margin-top: 20px;
            color: var(--recruitment-text);
        }

        .recruitment-section-heading p {
            font-size: 18px;
            line-height: 1.6;
            color: var(--recruitment-muted);
        }

        .recruitment-plan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .recruitment-plan-card {
            position: relative;
            padding: 34px;
            display: flex;
            flex-direction: column;
        }

        .recruitment-plan-card.featured {
            border: 2px solid var(--recruitment-blue);
            transform: translateY(-18px);
            background: linear-gradient(160deg, #0ea5e9 0%, #38bdf8 68%, #14b8a6 100%);
            color: #fff;
        }

        .recruitment-plan-card--technical.featured {
            background: linear-gradient(180deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--recruitment-text);
            border-color: #7dd3fc;
        }

        .recruitment-featured-label {
            position: absolute;
            top: 0;
            right: 28px;
            transform: translateY(-50%);
            background: linear-gradient(135deg, var(--recruitment-blue-dark), var(--recruitment-blue));
            color: white;
            border-radius: 999px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 900;
        }

        .recruitment-price {
            font-size: 52px;
            line-height: 1;
            font-weight: 900;
            color: var(--recruitment-blue-dark);
            letter-spacing: -0.05em;
            margin: 22px 0 6px;
        }

        .recruitment-per {
            font-size: 14px;
            font-weight: 700;
            color: var(--recruitment-muted);
        }

        .recruitment-range {
            font-weight: 900;
            color: var(--recruitment-text);
            margin-top: 26px;
        }

        .recruitment-plan-card p:not(.recruitment-per):not(.recruitment-range) {
            color: var(--recruitment-muted);
            line-height: 1.55;
        }

        .recruitment-plan-card.featured .recruitment-price,
        .recruitment-plan-card.featured .recruitment-per,
        .recruitment-plan-card.featured .recruitment-range,
        .recruitment-plan-card.featured p,
        .recruitment-plan-card.featured h3,
        .recruitment-plan-card.featured li {
            color: #fff;
        }

        .recruitment-plan-card--technical.featured .recruitment-price,
        .recruitment-plan-card--technical.featured .recruitment-per,
        .recruitment-plan-card--technical.featured .recruitment-range,
        .recruitment-plan-card--technical.featured p,
        .recruitment-plan-card--technical.featured h3,
        .recruitment-plan-card--technical.featured li {
            color: var(--recruitment-text);
        }

        .recruitment-plan-card ul {
            padding: 0;
            margin: 22px 0 30px;
            list-style: none;
            display: grid;
            gap: 12px;
        }

        .recruitment-plan-card li {
            font-size: 15px;
            font-weight: 650;
            color: #344054;
        }

        .recruitment-plan-card li.recruitment-guarantee-item {
            color: #64748b;
        }

        .recruitment-plan-card li::before {
            content: '✓';
            color: var(--recruitment-blue);
            font-weight: 900;
            margin-right: 10px;
        }

        .recruitment-plan-card.featured li::before {
            color: #e0f2fe;
        }

        .recruitment-plan-card--technical.featured li::before {
            color: var(--recruitment-blue-dark);
        }

        .recruitment-plan-card .recruitment-btn {
            margin-top: auto;
            width: 100%;
        }

        .recruitment-plan-card--managerial {
            grid-column: 2;
        }

        .recruitment-steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .recruitment-steps-grid article {
            padding: 28px;
            min-height: 180px;
        }

        .recruitment-steps-grid b {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--recruitment-blue-dark), var(--recruitment-blue));
            color: white;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .recruitment-steps-grid h3 {
            margin-bottom: 10px;
            color: var(--recruitment-text);
        }

        .recruitment-steps-grid p,
        .recruitment-associated-grid p,
        .recruitment-terms-grid p,
        .recruitment-note-card p {
            color: var(--recruitment-muted);
            line-height: 1.6;
        }

        .recruitment-guarantee-section {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 48%, #0ea5e9 100%);
            color: white;
            padding: 96px 0;
        }

        .recruitment-guarantee-grid {
            display: grid;
            grid-template-columns: 1fr 430px;
            gap: 90px;
            align-items: center;
        }

        .recruitment-guarantee-section h2 {
            font-size: 48px;
        }

        .recruitment-guarantee-section p {
            font-size: 20px;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.9);
        }

        .recruitment-note-card {
            padding: 36px;
            color: var(--recruitment-text);
        }

        .recruitment-note-card h3 {
            color: var(--recruitment-blue-dark);
            font-size: 28px;
        }

        .recruitment-note-card p {
            font-size: 17px;
        }

        .recruitment-note-card .recruitment-note-text {
            color: #000000;
        }

        .recruitment-note-card .recruitment-btn {
            margin-top: 20px;
        }

        .recruitment-associated-grid,
        .recruitment-terms-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .recruitment-associated-grid article,
        .recruitment-terms-grid article {
            padding: 34px;
        }

        .recruitment-associated-grid strong {
            display: block;
            font-size: 40px;
            color: var(--recruitment-blue-dark);
            font-weight: 900;
            margin: 22px 0 14px;
        }

        .recruitment-final-cta {
            margin-top: 96px;
            margin-bottom: 96px;
            border-radius: 32px;
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 72%, #14b8a6 100%);
            color: white;
            padding: 72px;
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 70px;
            align-items: center;
        }

        .recruitment-final-cta h2 {
            font-size: 48px;
        }

        .recruitment-final-cta p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 720px;
        }

        .recruitment-final-cta address {
            font-style: normal;
            display: grid;
            gap: 12px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 22px;
            padding: 28px;
        }

        .recruitment-final-cta address strong {
            font-size: 22px;
        }

        .recruitment-final-cta address span,
        .recruitment-final-cta address a {
            color: rgba(255, 255, 255, 0.88);
            text-decoration: none;
        }

        @media (max-width: 1050px) {
            .recruitment-hero-grid,
            .recruitment-guarantee-grid,
            .recruitment-final-cta {
                grid-template-columns: 1fr;
            }

            .recruitment-quick-stats,
            .recruitment-plan-grid,
            .recruitment-steps-grid,
            .recruitment-associated-grid,
            .recruitment-terms-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .recruitment-plan-card--managerial {
                grid-column: auto;
            }

            .recruitment-page h1 {
                font-size: 56px;
            }

            .recruitment-plan-card.featured {
                transform: none;
            }
        }

        @media (max-width: 700px) {
            .recruitment-container {
                width: calc(100% - 32px);
            }

            .recruitment-hero {
                padding: 54px 0 70px;
            }

            .recruitment-hero-grid {
                gap: 36px;
            }

            .recruitment-page h1 {
                font-size: 43px;
                line-height: 1.08;
            }

            .recruitment-hero p {
                font-size: 18px;
            }

            .recruitment-hero-panel {
                padding: 26px;
                min-height: auto;
            }

            .recruitment-quick-stats {
                grid-template-columns: 1fr;
                margin-top: 24px;
            }

            .recruitment-section {
                padding: 72px 0;
            }

            .recruitment-plan-grid,
            .recruitment-steps-grid,
            .recruitment-associated-grid,
            .recruitment-terms-grid {
                grid-template-columns: 1fr;
            }

            .recruitment-plan-card--managerial {
                grid-column: auto;
            }

            .recruitment-page h2,
            .recruitment-guarantee-section h2,
            .recruitment-final-cta h2 {
                font-size: 34px;
            }

            .recruitment-plan-card {
                padding: 28px;
            }

            .recruitment-final-cta {
                padding: 34px 24px;
                margin-top: 64px;
                margin-bottom: 64px;
            }

            .recruitment-actions {
                flex-direction: column;
            }

            .recruitment-actions .recruitment-btn {
                width: 100%;
            }

            .recruitment-guarantee-section {
                padding: 72px 0;
            }

            .recruitment-price {
                font-size: 46px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="recruitment-page">
        @include('partials.navbar')

        <main>
            <section class="recruitment-hero">
                <div class="recruitment-container recruitment-hero-grid">
                    <div class="recruitment-hero-copy">
                        <span class="recruitment-eyebrow">Servicio para empresas</span>
                        <h1>Reclutamiento y Selección de Personal</h1>
                        <p>
                            Encontramos, filtramos y presentamos candidatos calificados para cargos
                            operacionales, técnicos, profesionales y gerenciales, con una propuesta visual más clara,
                            moderna y alineada con una identidad azul más confiable.
                        </p>
                        <div class="recruitment-actions">
                            <a class="recruitment-btn recruitment-btn--primary" href="#contacto">Solicitar servicio</a>
                            <a class="recruitment-btn recruitment-btn--ghost" href="#planes">Ver planes</a>
                        </div>
                    </div>

                    <div class="recruitment-hero-panel" aria-label="Resumen del proceso">
                        <div class="recruitment-panel-badge">Terna calificada</div>
                        <h2>Del perfil al candidato ideal</h2>
                        <div class="recruitment-check-list">
                            <div><span></span>Publicación nacional</div>
                            <div><span></span>Filtro de CV</div>
                            <div><span></span>Entrevistas presenciales o remotas</div>
                            <div><span></span>Presentación de terna</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="recruitment-container recruitment-quick-stats">
                <article><strong>7 a 10 días</strong><span>Proceso aproximado según tipo de cargo</span></article>
                <article><strong>4 niveles</strong><span>Operacional, técnico, profesional y gerencial</span></article>
                <article><strong>1 mes</strong><span>Garantía de reposición</span></article>
                <article><strong>Cobertura amplia</strong><span>Publicación en portales y redes sociales</span></article>
            </section>

            <section id="planes" class="recruitment-section recruitment-plans-section">
                <div class="recruitment-container">
                    <div class="recruitment-section-heading">
                        <span class="recruitment-eyebrow dark">Servicios principales</span>
                        <h2>Planes de reclutamiento por tipo de cargo</h2>
                        <p>Elegimos una estructura basada en tu referencia, reforzando una paleta azul clara para transmitir confianza, orden y claridad.</p>
                    </div>

                    <div class="recruitment-plan-grid">
                        <article class="recruitment-plan-card">
                            <h3>Cargos Operacionales</h3>
                            <div class="recruitment-price">3 UF</div>
                            <p class="recruitment-per">por candidato seleccionado</p>
                            <p class="recruitment-range">Hasta $600.000 líquidos</p>
                            <p>Para operarios, ayudantes, auxiliares, asistentes, estafetas, peonetas y cargos similares.</p>
                            <ul>
                                <li>Análisis de cargo</li>
                                <li>Publicación nacional</li>
                                <li>Filtro de CV</li>
                                <li>Entrevistas</li>
                                <li>Entrega de terna</li>
                                <li>Proceso aproximado: 7 días hábiles</li>
                                <li class="recruitment-guarantee-item">Garantía de reposición por 1 mes</li>
                            </ul>
                            <a class="recruitment-btn recruitment-btn--secondary" href="#contacto">Solicitar plan</a>
                        </article>

                        <article class="recruitment-plan-card recruitment-plan-card--technical featured">
                            <span class="recruitment-featured-label">Más solicitado</span>
                            <h3>Cargos Técnicos</h3>
                            <div class="recruitment-price">7 UF</div>
                            <p class="recruitment-per">por candidato seleccionado</p>
                            <p class="recruitment-range">$600.001 a $900.000 líquidos</p>
                            <p>Para analistas, administrativos, cocineros, enfermeros, asistentes, vendedores y cargos técnicos.</p>
                            <ul>
                                <li>Levantamiento del perfil</li>
                                <li>Validación de descripción de cargo</li>
                                <li>Publicación nacional</li>
                                <li>Selección de CV ajustados</li>
                                <li>Entrevistas presenciales o remotas</li>
                                <li>Proceso aproximado: 10 días hábiles</li>
                                <li class="recruitment-guarantee-item">Garantía de reposición por 1 mes</li>
                            </ul>
                            <a class="recruitment-btn recruitment-btn--primary" href="#contacto">Solicitar plan</a>
                        </article>

                        <article class="recruitment-plan-card">
                            <h3>Cargos Profesionales</h3>
                            <div class="recruitment-price">10 UF</div>
                            <p class="recruitment-per">por candidato seleccionado</p>
                            <p class="recruitment-range">$900.001 a $1.900.000 líquidos</p>
                            <p>Para encargados, ingenieros, médicos, enfermeros profesionales y especialistas.</p>
                            <ul>
                                <li>Análisis completo del perfil</li>
                                <li>Publicación nacional</li>
                                <li>Filtro especializado</li>
                                <li>Entrevistas</li>
                                <li>Presentación de terna</li>
                                <li>Proceso aproximado: 10 días hábiles</li>
                                <li class="recruitment-guarantee-item">Garantía de reposición por 1 mes</li>
                            </ul>
                            <a class="recruitment-btn recruitment-btn--secondary" href="#contacto">Solicitar plan</a>
                        </article>

                        <article class="recruitment-plan-card recruitment-plan-card--managerial">
                            <h3>Cargos Gerenciales</h3>
                            <div class="recruitment-price">18 UF</div>
                            <p class="recruitment-per">por candidato seleccionado</p>
                            <p class="recruitment-range">Desde $1.900.000 líquidos hacia arriba</p>
                            <p>Para gerencias, subgerencias, jefaturas estratégicas, direcciones y cargos de alta responsabilidad.</p>
                            <ul>
                                <li>Análisis completo del perfil</li>
                                <li>Publicación nacional</li>
                                <li>Filtro especializado</li>
                                <li>Entrevistas por competencias</li>
                                <li>Presentación de terna</li>
                                <li>Proceso aproximado: 10 días hábiles</li>
                                <li class="recruitment-guarantee-item">Garantía de reposición por 1 mes</li>
                            </ul>
                            <a class="recruitment-btn recruitment-btn--secondary" href="#contacto">Solicitar plan</a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="recruitment-section recruitment-process-section">
                <div class="recruitment-container">
                    <div class="recruitment-section-heading compact">
                        <span class="recruitment-eyebrow dark">Proceso</span>
                        <h2>Cómo funciona nuestro reclutamiento</h2>
                    </div>
                    <div class="recruitment-steps-grid">
                        <article><b>1</b><h3>Envío del perfil</h3><p>El cliente envía la descripción del cargo que necesita reclutar.</p></article>
                        <article><b>2</b><h3>Análisis del cargo</h3><p>Revisamos funciones, requisitos, renta y condiciones junto al cliente.</p></article>
                        <article><b>3</b><h3>Aprobación del perfil</h3><p>Validamos la descripción final por correo electrónico.</p></article>
                        <article><b>4</b><h3>Publicación</h3><p>Difundimos la oferta en portales de empleo y redes sociales.</p></article>
                        <article><b>5</b><h3>Filtro y entrevistas</h3><p>Seleccionamos CV y entrevistamos candidatos de forma presencial o remota.</p></article>
                        <article><b>6</b><h3>Entrega de terna</h3><p>Presentamos candidatos calificados para que el cliente elija.</p></article>
                    </div>
                </div>
            </section>

            <section class="recruitment-guarantee-section">
                <div class="recruitment-container recruitment-guarantee-grid">
                    <div>
                        <span class="recruitment-eyebrow">Garantía incluida</span>
                        <h2>Garantía de reposición por 1 mes</h2>
                        <p>Todos los servicios incluyen garantía de reposición desde el día en que el candidato seleccionado comienza a trabajar con el cliente.</p>
                    </div>
                    <article class="recruitment-note-card">
                        <h3>Importante</h3>
                        <p class="recruitment-note-text">La garantía no aplica si el cliente no contacta a los candidatos dentro de 5 días hábiles y al sexto día ya no están disponibles por haber encontrado trabajo.</p>
                        <a class="recruitment-btn recruitment-btn--primary" href="#contacto">Hablar con asesor</a>
                    </article>
                </div>
            </section>

            <section class="recruitment-section recruitment-associated-section">
                <div class="recruitment-container">
                    <div class="recruitment-section-heading compact">
                        <span class="recruitment-eyebrow dark">Complementos</span>
                        <h2>Servicios asociados</h2>
                    </div>
                    <div class="recruitment-associated-grid">
                        <article><h3>Consulta de antecedentes</h3><strong>$6.000</strong><p>Antecedentes penales nacionales e internacionales por candidato.</p></article>
                        <article><h3>Pruebas psicológicas</h3><strong>3 UF</strong><p>Tres pruebas psicológicas adecuadas a la descripción de cargo.</p></article>
                        <article><h3>Venta de currículums</h3><strong>$5.000</strong><p>Publicamos, analizamos CV recibidos y enviamos perfiles que cumplen requisitos.</p></article>
                    </div>
                </div>
            </section>

            <section class="recruitment-section recruitment-terms-section">
                <div class="recruitment-container">
                    <div class="recruitment-section-heading compact">
                        <span class="recruitment-eyebrow dark">Condiciones</span>
                        <h2>Condiciones comerciales</h2>
                    </div>
                    <div class="recruitment-terms-grid">
                        <article><h3>Clientes nuevos</h3><p>Cancelan 40% del valor total neto por concepto de gastos operacionales.</p></article>
                        <article><h3>Desistimiento</h3><p>Si el proceso ya comenzó, se cobra 40% del valor total neto.</p></article>
                        <article><h3>Gastos incluidos</h3><p>Descripción de cargo, avisos destacados, psicólogo y validación contractual.</p></article>
                    </div>
                </div>
            </section>

            <section id="contacto" class="recruitment-final-cta recruitment-container">
                <div>
                    <span class="recruitment-eyebrow">Solicita una cotización</span>
                    <h2>¿Necesitas contratar personal para tu empresa?</h2>
                    <p>Déjanos ayudarte a encontrar candidatos calificados de forma rápida, profesional y segura.</p>
                    <div class="recruitment-actions">
                        <a class="recruitment-btn recruitment-btn--primary" href="mailto:mzuniga@encontretrabajo.cl">Solicitar servicio</a>
                        <a class="recruitment-btn recruitment-btn--ghost" href="tel:+56964647718">Hablar con asesor</a>
                    </div>
                </div>
                <address>
                    <strong>Marcelo Zúñiga</strong>
                    <span>Gerente General</span>
                    <a href="mailto:mzuniga@encontretrabajo.cl">mzuniga@encontretrabajo.cl</a>
                    <a href="tel:+56964647718">+56 9 6464 7718</a>
                </address>
            </section>
        </main>
    </div>
@endsection
