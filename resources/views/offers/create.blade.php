@extends('layouts.main')

@push('css')
    <style>
        .offer-create { padding: 130px 0 60px; }
        .offer-create__card { border: 0; border-radius: 14px; box-shadow: 0 12px 35px rgba(15, 23, 42, .12); }
        .offer-create__submit { background: #1675a9; border-color: #1675a9; }
        .offer-create__submit:hover { background: #105b85; border-color: #105b85; }
        .offer-create__account-tabs .nav-link { color: #536273; }
        .offer-create__account-tabs .nav-link.active { color: #1675a9; font-weight: 600; }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <main class="offer-create">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card offer-create__card">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="h3 mb-2">Publicar una oferta</h1>
                            <p class="text-muted mb-4">Completa los datos para que las personas puedan encontrar tu vacante.</p>

                            <form method="POST" action="{{ route('offers.store') }}" novalidate>
                                @csrf
                                <div class="border rounded p-3 mb-4">
                                    <p class="font-weight-bold mb-2">Cuenta de empresa</p>
                                    <ul class="nav nav-tabs offer-create__account-tabs mb-3" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link {{ old('account_mode', 'login') === 'login' ? 'active' : '' }}" type="button" data-account-mode="login">Iniciar sesión</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link {{ old('account_mode') === 'register' ? 'active' : '' }}" type="button" data-account-mode="register">Registrarme</button>
                                        </li>
                                    </ul>
                                    <input id="account_mode" name="account_mode" type="hidden" value="{{ old('account_mode', 'login') }}">

                                    <div id="company-name-field" class="form-group">
                                        <label for="company_name">Nombre de la empresa</label>
                                        <input id="company_name" name="company_name" type="text" maxlength="255" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" autocomplete="organization">
                                        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo electrónico</label>
                                        <input id="email" name="email" type="email" maxlength="255" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="password">Contraseña</label>
                                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div id="password-confirmation-field" class="form-group mb-0 mt-3">
                                        <label for="password_confirmation">Confirmar contraseña</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                                        @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Título de la oferta</label>
                                        <input id="title" name="title" type="text" maxlength="150" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required autofocus>
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="job_position">Puesto de trabajo</label>
                                        <input id="job_position" name="job_position" type="text" maxlength="150" class="form-control @error('job_position') is-invalid @enderror" value="{{ old('job_position') }}" required>
                                        @error('job_position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category_id">Categoría</label>
                                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                            <option value="">Selecciona una categoría</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="expiration_date">Fecha de cierre</label>
                                        <input id="expiration_date" name="expiration_date" type="date" min="{{ now()->format('Y-m-d') }}" class="form-control @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date', $expirationDate) }}" required>
                                        @error('expiration_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="region_id">Región</label>
                                        <select id="region_id" name="region_id" class="form-control @error('region_id') is-invalid @enderror" required>
                                            <option value="">Selecciona una región</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('region_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="commune_id">Comuna <span class="text-muted">(opcional)</span></label>
                                        <select id="commune_id" name="commune_id" class="form-control @error('commune_id') is-invalid @enderror" disabled>
                                            <option value="">Primero selecciona una región</option>
                                        </select>
                                        @error('commune_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección o referencia <span class="text-muted">(opcional)</span></label>
                                    <input id="address" name="address" type="text" maxlength="255" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea id="description" name="description" rows="7" maxlength="5000" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                    <small class="form-text text-muted">Incluye funciones, requisitos y cómo postular.</small>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-5">
                                        <label for="wage_type">Renta</label>
                                        <select id="wage_type" name="wage_type" class="form-control @error('wage_type') is-invalid @enderror" required>
                                            <option value="1" {{ old('wage_type', '1') === '1' ? 'selected' : '' }}>Indicar monto</option>
                                            <option value="0" {{ old('wage_type') === '0' ? 'selected' : '' }}>A convenir</option>
                                        </select>
                                        @error('wage_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div id="wage-field" class="form-group col-md-5">
                                        <label for="min_wage">Monto</label>
                                        <input id="min_wage" name="min_wage" type="number" min="0" step="1" class="form-control @error('min_wage') is-invalid @enderror" value="{{ old('min_wage') }}">
                                        @error('min_wage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block offer-create__submit">Publicar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        (function () {
            var region = document.getElementById('region_id');
            var commune = document.getElementById('commune_id');
            var wageType = document.getElementById('wage_type');
            var wageField = document.getElementById('wage-field');
            var wageInput = document.getElementById('min_wage');
            var selectedCommune = '{{ old('commune_id') }}';
            var accountMode = document.getElementById('account_mode');
            var accountTabs = document.querySelectorAll('[data-account-mode]');
            var companyNameField = document.getElementById('company-name-field');
            var companyNameInput = document.getElementById('company_name');
            var passwordConfirmationField = document.getElementById('password-confirmation-field');
            var passwordConfirmationInput = document.getElementById('password_confirmation');

            function updateWageField() {
                var visible = wageType.value === '1';
                wageField.style.display = visible ? '' : 'none';
                wageInput.required = visible;
            }

            function updateAccountFields() {
                var registering = accountMode.value === 'register';
                companyNameField.style.display = registering ? '' : 'none';
                passwordConfirmationField.style.display = registering ? '' : 'none';
                companyNameInput.required = registering;
                passwordConfirmationInput.required = registering;
                document.getElementById('password').setAttribute('autocomplete', registering ? 'new-password' : 'current-password');
            }

            function loadCommunes() {
                commune.innerHTML = '<option value="">Cargando comunas...</option>';
                commune.disabled = true;
                if (!region.value) {
                    commune.innerHTML = '<option value="">Primero selecciona una región</option>';
                    return;
                }
                axios.get('{{ url('/communes') }}/' + region.value).then(function (response) {
                    commune.innerHTML = '<option value="">Selecciona una comuna</option>';
                    response.data.communes.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        option.selected = String(item.id) === selectedCommune;
                        commune.appendChild(option);
                    });
                    commune.disabled = false;
                }).catch(function () {
                    commune.innerHTML = '<option value="">No fue posible cargar las comunas</option>';
                });
            }

            region.addEventListener('change', function () { selectedCommune = ''; loadCommunes(); });
            wageType.addEventListener('change', updateWageField);
            accountTabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    accountMode.value = tab.getAttribute('data-account-mode');
                    accountTabs.forEach(function (item) { item.classList.toggle('active', item === tab); });
                    updateAccountFields();
                });
            });
            updateWageField();
            updateAccountFields();
            if (region.value) { loadCommunes(); }
        }());
    </script>
@endpush
