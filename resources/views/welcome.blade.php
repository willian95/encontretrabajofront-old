@extends('layouts.main')

@section('content')

    @include('partials.navbar')         
      <!--Banner-->
    <section class="banner">
        <div id="demo" class="carrusel-principal" data-ride="carousel">
            
                {{--<div class="carousel-item active">
                    <img class="img-carrusel-banner-et" src="{{ asset('assets/img/Banner-01.png') }} " alt=" banner encontre trabajo">  
                </div>
                <div class="carousel-item">
                    <img  class="img-carrusel-banner-et" src="{{ asset('assets/img/Banner-02.png') }}" alt="banner encontre trabajo">
                </div>--}}
                
                    <video  class="img-carrusel-banner-et" loop style="width: 100%;" autoplay="true" muted="muted">
                        <source src="{{ asset('assets/img/banner-video.mp4') }}" type="video/mp4">
                    </video>
             
               {{--@foreach(App\Carousel::where('status', 1)->get() as $carousel)
                    <div class="carousel-item @if($loop->index == 0) active @endif">
                        <img class="img-carrusel-banner-et" src="{{ $carousel->image }} " alt=" banner encontre trabajo">  
                    </div>
                @endforeach--}}
           
            
            <div class="carrusel-principal-inf">
    
                <div style="width: 100%; height: 100%; top: 0; position: absolute; background-color: rgba(0, 0, 0, 0.2)">
                    <div class="carrusel-principal-inf-logo">
                        <div class="carrusel-principal-inf-logo-img"><img class="carrusel-principal-inf-logo-img_img" src="{{ asset('assets/img/logop.png') }}" alt=""></div>
                    </div>
                    
                    <div class="buscador">
                        <input class="buscador-et" type="text" placeholder="Busca tu nuevo trabajo" id="job_search">
                        <select name="" class="select-buscador" id="region_search">
                            @foreach(App\Region::all() as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-lupa-et" onclick="storeQuery()"> <img class="buscador_img" src="{{ asset('assets/img/lupa-buscador.png') }}" alt=""> </button>
                    </div>
                    <!-- <div class="div-postulate"><a class=" btn-et" href="{{ env('PLATFORM_URL').'/register' }}">Postulate YA</a></div> -->
                    <!-- <h4 class="text-center text-azul">Más de 300 trabajos esperan por ti</h4> -->
                    <h3 class="text-center l-a text-banner-g">Publica tus ofertas laborales</h3>
                    <h3 class="text-center l-a text-banner-m">Alcanza a tu candidato ideal en tiempo record</h3>
                    <h3 class="text-center l-a text-banner-p">Publica tus ofertas laborales</h3>
                        <div class="grupo-btn-et">
                        <a class="grupo-btn-et_a" href="{{ env('PLATFORM_URL').'/' }}">Ingresa tu sesión</a>
                        <a class="grupo-btn-et_a" href="{{ env('PLATFORM_URL').'/register' }}">Crear tu cuenta</a>
                        <a class="grupo-btn-et_a" href="{{ env('PLATFORM_URL').'/offers/create' }}">Publica Gratis</a>
                        <a class="grupo-btn-et_azul" href="#" data-toggle="modal" data-target="#myModal" >VER PLANES</a>


                        <!-- <a class="grupo-btn-et_a" href="{{ env('PLATFORM_URL').'/offers/create' }}">Publica tu oferta laboral gratis</a>
                        <a class="grupo-btn-et_a" href="{{ env('PLATFORM_URL').'/home' }}">Busca tu empleo</a> -->
                    </div>
                </div>
            </div> 
        </section>
        <div class="modal " id="myModal">
            <div class="modal-dialog modal-planes">
                <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center-plan-t">
                    <h4 class="modal-title text-center">Nuestros Planes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                    <div class="row d-flex justify-content-center">
                        @foreach(App\Plan::where("position", 1)->orderBy("price", "asc")->get() as $plan)
                        <div class="col-md-3">
                            <div class="content-plan">   
                                <div class=" card-planes mb-3 mt-3">
                                    <div class="card">
                                        <div class="img-planes d-flex justify-content-center">
                                            <img src="{{ asset('assets/img/logop.png') }}" alt="logo encontre trabajo">
                                        </div>
                                        <h2 class="text-center text-uppercase">{{ $plan->title }}</h2>
                                        <h3 class="text-center"><small class="">$</small>{{ number_format($plan->price, 0, ",", ".") }}</h3>
                                        <h6 class="text-center text-uppercase">iva incluido</h6>
                                        <img class="wave_img" src="{{ asset('assets/img/wamarillo.svg') }}" alt="waves">

                                        <div class="box-waves fondo-am">
                                            <div class="box-waves_img">
                                            </div>

                                            <div class="box-waves-text fondo-am">
                                                <ul class="text-center box-waves-text_ul ">
                                                    @if($plan->offer_posting == 1)
                                                    <li >Publicación en la plataforma laboral y en nuestras redes sociales.</li>
                                                    @endif
                                                    @if($plan->post_days > 0)
                                                    <li>Duración de {{ $plan->post_days }} días.</li>
                                                    @endif
                                                    @if($plan->simple_post_infinity == 1)
                                                        Publicaciones simples ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif
                                                    @elseif($plan->simple_posts > 0)
                                                    <li>{{ $plan->simple_posts }} @if($plan->simple_posts == 1)publicación simple. @else publicaciones simples. @endif</li>
                                                    @endif
                                                    @if($plan->hightlight_posts > 0)
                                                    <li>{{ $plan->hightlight_posts }} @if($plan->hightlight_posts == 1) publicación destacada. @else publicaciones destacadas. @endif</li>
                                                    @endif
                                                    @if($plan->download_curriculum == 1)
                                                    <li>Descarga de Curriculum Vitae.</li>
                                                    @endif
                                                    @if($plan->show_video == 1)
                                                    <li>Video de Presentación del Candidato.</li>
                                                    @endif
                                                    @if($plan->download_profiles > 0)
                                                    <li>Podrás entrar al motor de búsqueda y descargar {{ $plan->download_profiles }} @if($plan->download_profiles == 1) perfil. @else perfiles. @endif</li>
                                                    @endif
                                                    @if($plan->conference_infinity == 1)
                                                        <li>Video entrevistas Ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif</li>
                                                    @elseif($plan->conference_amount > 0)
                                                        <li>{{ $plan->conference_amount }} @if($plan->conference_amount == 1)video entrevista con postulantes. @else video entrevista con postulantes. @endif</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row d-flex justify-content-center">
                        @foreach(App\Plan::where("position", 2)->orderBy("price", "asc")->get() as $plan)
                        <div class="col-md-3">
                            <div class="content-plan">   
                                <div class=" card-planes mb-3 mt-3">
                                    <div class="card">
                                        <div class="img-planes d-flex justify-content-center">
                                            <img src="{{ asset('assets/img/logop.png') }}" alt="logo encontre trabajo">
                                        </div>
                                        <h2 class="text-center text-uppercase">{{ $plan->title }}</h2>
                                        <h3 class="text-center"><small class="">$</small>{{ number_format($plan->price, 0, ",", ".") }}</h3>
                                        <h6 class="text-center text-uppercase">iva incluido</h6>
                                        <img class="wave_img" src="{{ asset('assets/img/wazul.svg') }}" alt="waves">

                                        <div class="box-waves fondo-az">
                                            <div class="box-waves_img">
                                            </div>

                                            <div class="box-waves-text fondo-az">
                                                <ul class="text-center box-waves-text_ul ">
                                                    @if($plan->offer_posting == 1)
                                                    <li >Publicación en la plataforma laboral y en nuestras redes sociales.</li>
                                                    @endif
                                                    @if($plan->post_days > 0)
                                                    <li>Duración de {{ $plan->post_days }} días.</li>
                                                    @endif
                                                    @if($plan->simple_post_infinity == 1)
                                                        Publicaciones simples ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif
                                                    @elseif($plan->simple_posts > 0)
                                                    <li>{{ $plan->simple_posts }} @if($plan->simple_posts == 1)publicación simple. @else publicaciones simples. @endif</li>
                                                    @endif
                                                    @if($plan->hightlight_posts > 0)
                                                    <li>{{ $plan->hightlight_posts }} @if($plan->hightlight_posts == 1) publicación destacada. @else publicaciones destacadas. @endif</li>
                                                    @endif
                                                    @if($plan->download_curriculum == 1)
                                                    <li>Descarga de Curriculum Vitae.</li>
                                                    @endif
                                                    @if($plan->show_video == 1)
                                                    <li>Video de Presentación del Candidato.</li>
                                                    @endif
                                                    @if($plan->download_profiles > 0)
                                                    <li>Podrás entrar al motor de búsqueda y descargar {{ $plan->download_profiles }} @if($plan->download_profiles == 1) perfil. @else perfiles. @endif</li>
                                                    @endif
                                                    @if($plan->conference_infinity == 1)
                                                        <li>Entrevistas Ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif</li>
                                                    @elseif($plan->conference_amount > 0)
                                                        <li>{{ $plan->conference_amount }} @if($plan->conference_amount == 1)video entrevista con postulantes. @else video entrevista con postulantes. @endif</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row d-flex justify-content-center">
                        @foreach(App\Plan::where("position", 3)->orderBy("price", "asc")->get() as $plan)
                        <div class="col-md-3">
                            <div class="content-plan">   
                                <div class=" card-planes mb-3 mt-3">
                                    <div class="card">
                                        <div class="img-planes d-flex justify-content-center">
                                            <img src="{{ asset('assets/img/logop.png') }}" alt="logo encontre trabajo">
                                        </div>
                                        <h2 class="text-center text-uppercase">{{ $plan->title }}</h2>
                                        <h3 class="text-center"><small class="">$</small>{{ number_format($plan->price, 0, ",", ".") }}</h3>
                                        <h6 class="text-center text-uppercase">iva incluido</h6>
                                        <img class="wave_img" src="{{ asset('assets/img/wverde.svg') }}" alt="waves">

                                        <div class="box-waves fondo-ve">
                                            <div class="box-waves_img">
                                            </div>

                                            <div class="box-waves-text fondo-ve">
                                                <ul class="text-center box-waves-text_ul ">
                                                    @if($plan->offer_posting == 1)
                                                    <li >Publicación en la plataforma laboral y en nuestras redes sociales.</li>
                                                    @endif
                                                    @if($plan->post_days > 0)
                                                    <li>Duración de {{ $plan->post_days }} días.</li>
                                                    @endif

                                                    @if($plan->simple_post_infinity == 1)
                                                        Publicaciones simples ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif
                                                    @elseif($plan->simple_posts > 0)
                                                    <li>{{ $plan->simple_posts }} @if($plan->simple_posts == 1)publicación simple. @else publicaciones simples. @endif</li>
                                                    @endif
                                                    @if($plan->hightlight_posts > 0)
                                                    <li>{{ $plan->hightlight_posts }} @if($plan->hightlight_posts == 1) publicación destacada. @else publicaciones destacadas. @endif</li>
                                                    @endif
                                                    @if($plan->download_curriculum == 1)
                                                    <li>Descarga de Curriculum Vitae.</li>
                                                    @endif
                                                    @if($plan->show_video == 1)
                                                    <li>Video de Presentación del Candidato.</li>
                                                    @endif
                                                    @if($plan->download_profiles > 0)
                                                    <li>Podrás entrar al motor de búsqueda y descargar {{ $plan->download_profiles }} @if($plan->download_profiles == 1) perfil. @else perfiles. @endif</li>
                                                    @endif
                                                    @if($plan->conference_infinity == 1)
                                                        <li>Entrevistas Ilimitadas por @if($plan->plan_time == "semestrales") 6 meses @elseif($plan->plan_time == "anuales") 12 meses @endif</li>
                                                    @elseif($plan->conference_amount > 0)
                                                        <li>{{ $plan->conference_amount }} @if($plan->conference_amount == 1)video entrevista con postulantes. @else video entrevista con postulantes. @endif</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style=" background: #26988a; border: transparent;">Cerrar</button>
                </div>

                </div>
            </div>
        </div>
        <section class="ofertas">
            <h3  class=" text-center text-azul">Empresas que <strong><u>publican con nosotros</u></strong></h3>
            <div class="container ofertas-opciones">
                <div class="row ofertas-opciones-row">
                    
                    @foreach(App\LandingBusiness::all() as $landing)
                        <div class="col-md-2 ofertas-opciones-item">
                            <a href="#"> 
                                <p class="text-center">
                                    <img style="width: 100%;" src="{{ $landing->image }}">
                                </p>
                            </a>
                        </div>
                    @endforeach
                    
                
                </div>
            </div>
        </section> 

        <section class="ofertas">
            <h3  class=" text-center text-azul">Hoy hay <strong><u>1500 empresas</u></strong> contratando</h3>
            <div class="container ofertas-opciones">
                <div class="row ofertas-opciones-row">
                    @foreach(App\Offer::take(12)->with("user")->has("user")->where('status', 'abierto')->whereDate('expiration_date', '>', Carbon\Carbon::today()->toDateString())->get() as $offer)
                        <div class="col-md-2 ofertas-opciones-item">
                            <a href="{{ env('PLATFORM_URL').'/offers/detail/'.$offer->slug }}"> 
                                <p class="text-center">
                                    <img class="ofertas-opciones-item-img" src="{{ $offer->user->image }}">
                                </p>
                                <h3 class="text-center">{{ $offer->title }}</h3>
                                <h5 class="ofertas-opciones-item-h5">Ver oferta</h5>
                            </a>
                        </div>
                    @endforeach
                
                </div>
            </div>
        </section> 
      <section class="opcion-en-web-et">
        <div class="container opcion-en-web-et-container">
            <div class="row">
                @foreach(App\Notice::orderBy("id", "desc")->take(4)->get() as $notice)
                <div class="col-md-3 opcion-en-web-et-container-col">
                    <a href="{{ url('/noticia/'.$notice->slug) }}">
                        <div class="opcion-en-web-et-container-col">
                            <!--<div class="opcion-en-web-et-container-col-box"></div>-->
                            <img src="{{ $notice->image }}" style="width: 100%;" alt="">
                        </div>
                        <h6 class="opcion-en-web-et-container-col_h6">{{ $notice->title }}</h6>
                    </a>
                </div>
                @endforeach
                {{--<div class="col-md-3 opcion-en-web-et-container-col">
                   <a href="">
                        <div class="opcion-en-web-et-container-col"><div class="opcion-en-web-et-container-col-box"></div></div>
                        <h6 class="opcion-en-web-et-container-col_h6">Nuevos empleos diariamente</h6>
                    </a>
                    </div>
                <div class="col-md-3 opcion-en-web-et-container-col">
                     <a href="">   
                        <div class="opcion-en-web-et-container-col"><div class="opcion-en-web-et-container-col-box"></div></div>
                        <h6 class="opcion-en-web-et-container-col_h6">Ofertas seleccionadas en tu correo</h6>
                    </a>
                </div>
                <div class="col-md-3 opcion-en-web-et-container-col">
                    <a href="">
                        <div class="opcion-en-web-et-container-col"><div class="opcion-en-web-et-container-col-box"></div></div>
                        <h6 class="opcion-en-web-et-container-col_h6">Completa tu perfil profesional</h6>
                    </a>
                </div>--}}
            </div>
        </div>
      </section>
      <section class="buscar-empleo-localizacion mb-2">
        <div class="container">
            <!--<h5 class="buscar-empleo-localizacion_h5"> Buscar empleos por localización</h5>-->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item ">
                <a class="nav-link link-tab-opcion-en-web active" data-toggle="tab" href="#home">Localización</a>
                </li>
                <li class="nav-item">
                <a class="nav-link link-tab-opcion-en-web" data-toggle="tab" href="#menu2">Categorias</a>
                </li>
                
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="container tab-pane active"><br>
                    <h3>Localización</h3>
                    {{-- <a href="#" onclick="jobsInCommunes('{{ $commune->id }}')">{{ $commune->name }}</a> --}}
                    <div class="row categorias-row" id="communes-dev">
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(1)" data-toggle="modal" data-target="#communesModal">Arica Parinacota</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(2)" data-toggle="modal" data-target="#communesModal">Tarapacá</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(9)" data-toggle="modal" data-target="#communesModal">Maule</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(13)" data-toggle="modal" data-target="#communesModal">Los Ríos</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(3)" data-toggle="modal" data-target="#communesModal">Antofagasta</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(4)" data-toggle="modal" data-target="#communesModal">Atacama</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(10)" data-toggle="modal" data-target="#communesModal">Ñuble</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(14)" data-toggle="modal" data-target="#communesModal">Los Lagos</a></li>

                            </ul>
                        </div>                        
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(5)" data-toggle="modal" data-target="#communesModal">Coquimbo</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(6)" data-toggle="modal" data-target="#communesModal">Valparaiso</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(11)" data-toggle="modal" data-target="#communesModal">Biobío</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(15)" data-toggle="modal" data-target="#communesModal">Aisén del General Carlos Ibáñez del Campo</a></li>
                                
                            </ul>
                        </div>
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(7)" data-toggle="modal" data-target="#communesModal">Metropolitana de Santiago</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(8)" data-toggle="modal" data-target="#communesModal">Libertador General Bernardo O'Higgins</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(12)" data-toggle="modal" data-target="#communesModal">La Araucania</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" @click="fetchCommunes(16)" data-toggle="modal" data-target="#communesModal">Magallanes y de la Antártica Chilena</a></li>
                                

                            </ul>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="communesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Comunas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <button type="button" class="btn btn-outline-primary btn-lg btn-block" v-for="commune in communes" @click="jobsInCommunes(commune.id)">@{{ commune.name }}</button>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            
                    </div>
                </div>
               
                <div id="menu3" class="container tab-pane fade"><br>
                <h3>Categorias</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>
                <div id="menu2" class="container tab-pane fade"><br>
                    <div class="row categorias-row">
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(1)">Administración</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(2)">Almacenamiento</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(2)">Atención de Clientes</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(4)">Arte / Diseño</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(5)">Call-Center</a></li>
                                
                            </ul>
                        </div>
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(7)">Compras / Comercio Exterior</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(8)">Comunicaciones</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(9)">Contabilidad</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(10)">Construcción</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(11)">Directores</a></li>
                                
                            </ul>
                        </div>                        
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(13)">Enferemería</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(14)">Gerentes</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(15)">Hotelería</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(16)">Informática</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(17)">Ingeniería</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(18)">Investigación</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(19)">Logística</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(20)">Manufactura</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(21)">Mantenimiento</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(22)">Marketing</a></li>

                            </ul>
                        </div>
                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(23)">Medicina</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(24)">Mercadotecnia</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(25)">Minería</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(26)">Obras</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(27)">Operarios / Operadores</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(28)">Producción</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(29)">Publicidad</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(30)">Recursos Humanos</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(31)">Reparaciones</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(32)">Técnicos</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(33)">Tele-comunicaciones</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(34)">Tele-mercadeo</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(35)">Transporte</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(36)">Turismo</a></li>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(37)">Ventas</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 categorias-row-col-3">
                            <ul>
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" onclick="categorySearch(38)">Servicios Generales, Aseo y Seguridad</a></li>

                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="" onclick="categorySearch(39)">Otros</a></li>       
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(6)">Calidad</a></li>                         
                                <li class="categorias-row-col-3_li"><a class="categorias-row-col-3_a" href="#" onclick="categorySearch(12)">Docentes / Educadores</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        

      </section>  
      <section class="nosotros">

        <!-- Modal -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Términos y condiciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum non mollis dolor. Mauris nec nunc lacus. Suspendisse ultricies sollicitudin dui, nec ultrices tellus laoreet sed. Donec convallis vulputate odio, vel suscipit lorem molestie eleifend. Fusce eget quam ut nulla auctor sagittis. Proin purus tortor, ultrices vitae suscipit nec, viverra non est. Maecenas rhoncus magna tortor, non gravida mauris mollis sed. Quisque justo metus, aliquet eget nisi in, ornare euismod est. Maecenas ultricies elit nec tristique viverra.

                        Aliquam ultrices velit vitae magna finibus congue quis ac tortor. Aliquam eget metus iaculis, ullamcorper urna vitae, convallis mi. Quisque porta, leo et feugiat eleifend, ante lectus fermentum erat, semper pulvinar sem ex a ipsum. Sed vitae metus ac arcu sodales tincidunt sed id lectus. Nam vitae hendrerit massa. Aenean mi ipsum, faucibus quis rutrum et, blandit et eros. Curabitur sem nulla, rhoncus ac ipsum varius, efficitur ultrices dolor.

                        In quis nulla lorem. Cras pulvinar mattis sapien, sit amet scelerisque nunc hendrerit sed. Nunc malesuada ante tincidunt nulla tincidunt, ut ultrices orci euismod. Phasellus rhoncus quam ullamcorper magna varius, eget euismod nisl blandit. Nullam a accumsan ante. Nam vel fermentum ligula, quis rhoncus nibh. Sed et malesuada turpis. Ut nec arcu sit amet diam elementum feugiat.

                        Aenean vitae tellus a orci aliquam luctus id sed diam. Suspendisse eu felis sodales, egestas leo et, iaculis mauris. Aenean venenatis scelerisque nibh. Phasellus rhoncus suscipit quam, nec viverra justo eleifend in. Ut quis diam libero. Morbi vel vulputate magna. Integer et est mi. Mauris venenatis accumsan blandit. Nunc a mollis nulla. Vivamus sit amet vulputate metus.

                        Proin finibus lectus eget congue porttitor. Nullam viverra tincidunt arcu, et lacinia lacus sollicitudin vel. Etiam nec lacinia tellus. Vestibulum malesuada elementum varius. Cras mollis vehicula erat, a tristique leo pretium et. Ut id lobortis libero. Maecenas commodo hendrerit neque, at scelerisque purus vestibulum ac. Nunc sit amet commodo dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean nisl tortor, vehicula nec risus sed, convallis iaculis leo. Etiam semper, erat non cursus vestibulum, urna ex dignissim tortor, sit amet luctus leo ipsum at metus. Sed porttitor ultrices sodales. Pellentesque lectus est, lobortis nec condimentum id, venenatis ac nunc.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

          <div class="container nosotros-container">
              <div class="row col-flex">
                    <div class="col-md-3 nosotros-container-row-col">
                        <h6 class="nosotros-container-row-col_h6">Institucional</h6>
                        <ul>
                         
                            <li><a class="nosotros-container-row-col_a" href="">Contacto para personas</a> </li>
                            <li><a class="nosotros-container-row-col_a" data-toggle="modal" data-target="#termsModal">Aviso Legal y Privacidad</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-3 nosotros-container-row-col">
                        <h6 class="nosotros-container-row-col_h6">Candidatos</h6>
                        <ul>
                                <li><a class="nosotros-container-row-col_a" href="">Preguntas frecuentes de candidatos</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empleos por Categoria</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empleos por ciudades </a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empleos por regiones</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empleos por carga profesional</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empleos por salario</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empresas por localización</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Empresas por industria</a></li>
                                <li><a class="nosotros-container-row-col_a" href="">Pruebas de aptitudes</a></li>
                        </ul>

                    </div>
                    <div class="col-md-3 nosotros-container-row-col">
                        <h6 class="nosotros-container-row-col_h6">Reclutadores</h6>
                        <ul>
                            <li><a class="nosotros-container-row-col_a" href="">Preguntas frecuentes de empresas</a></li>
                            <li><a class="nosotros-container-row-col_a" href="">Contacto para empresas</a></li>
                            <li><a class="nosotros-container-row-col_a" href="">Buscar candidatos </a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 nosotros-container-row-col">
                        <img class="nosotros-container-row-col_img" src="{{ asset('assets/img/Google-play-boton-color.png') }}" alt="">
                        <img style="margin-top: 15px;" class="nosotros-container-row-col_img" src="{{ asset('assets/img/App-store-boton-color.png') }}" alt="">
                        <img style="margin-top: 15px;" class="nosotros-container-row-col_img" src="{{ asset('assets/img/Logo-footer-color.png') }}" alt="">
                    </div>
                </div>
          </div>
      </section>   
                    
@endsection

@push("scripts")

    <script>
        const devArea = new Vue({
            el: '#communes-dev',
            data() {
                return {
                    
                    communes:[]

                }
            },
            methods: {

                
                fetchCommunes(region){
                    this.communes = []
                    axios.get("{{ url('/communes/') }}"+"/"+region).then(res => {

                        this.communes = res.data.communes

                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/job-categories/all') }}").then(res => {

                        this.categories = res.data.categories

                    })

                },
                jobsInCommunes(commune){
            
                    //alert(commune)
                    localStorage.setItem("encontre_trabajo_commune_search", commune)
                    window.location.href="{{ url('/search') }}"
                
                }

            },
            created(){
                
                //this.jobs()
                this.fetchRegions()
                this.fetchCategories()

                this.jobSearch = localStorage.getItem("encontre_trabajo_job_search")
                this.regionSearch = localStorage.getItem("encontre_trabajo_region_search")
                this.query()
                
            }

        })
    </script>

    <script>    
        function storeQuery(){
            
            let jobSearch = $("#job_search").val()
            let regionSearch = $("#region_search").val()
           
            if(jobSearch != null){
                localStorage.setItem("encontre_trabajo_job_search", jobSearch)
                localStorage.setItem("encontre_trabajo_region_search", regionSearch)
                window.location.href="{{ url('/jobs') }}"
            }
            
        }

        function categorySearch(id){
            
            localStorage.setItem("encontre_trabajo_category_search", id)
            window.location.href="{{ url('/search') }}"
        }


        $(document).ready(function(){

            localStorage.removeItem("encontre_trabajo_job_search")
            localStorage.removeItem("encontre_trabajo_region_search")
            localStorage.removeItem("encontre_trabajo_commune_search")

            var input = document.getElementById("job_search");

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
            //alert("event")
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                storeQuery()
                //document.getElementById("myBtn").click();
            }
            });
        })

    </script>
    

@endpush