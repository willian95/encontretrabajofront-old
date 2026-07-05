@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div id="search-dev" style="padding-top: 120px;">
    
        <div class="container-fluid">

            <div class="row" v-cloak >   
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-12">
                    <h3 v-if="jobSearch"><strong>Resultados de: </strong>@{{ jobSearch }}</h3>
                        </div>

                        <div class="col-12" v-if="offers.length == 0">
                    <h3 class="text-center">No hay trabajos para tus criterios de búsqueda</h3>
                        </div>

                        <div class="col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" v-if="page > 1">
                                        <a class="page-link" href="#" aria-label="Previous" @click="fetch(page -1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li v-for="index in pages" class="page-item" v-if="page == index && index >= page - 3 &&  index < page + 3"><a class="page-link" href="#" @click="fetch(index)">@{{ index }}</a></li>
                                    <li class="page-item" v-if="page < pages">
                                        <a class="page-link" href="#" aria-label="Next" @click="fetch(page + 3)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                {{--<div class="col-md-4" v-for="offer in offers">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center price-op" v-if="offer.wage_type == 1">
                                $ @{{ parseInt(offer.min_wage).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                            </p>
                            <p class="text-center price-op" v-else>
                                A convenir
                            </p>
                            <p v-if="offer.is_highlighted == 1">
                                <strong>Aviso destacado</strong>
                            </p>
                            <p class="text-center">
                                <img class="round-img" :src="offer.user.image" alt="Card image">
                            </p>
                            <p class="text-center text-b">@{{ offer.user.business_name }}</p>
                            <h5 class="card-title text-center">@{{ offer.job_position }}</h5>
                            <p class="card-text text-center">@{{ offer.title }}</p>
                            
                            <p class="text-center">
                                <a :href="'{{ env('PLATFORM_URL') }}'+'/offers/detail/'+offer.slug" class="btn btn-primary">Ver más</a>
                            </p>

                        </div>
                    </div>
                </div>--}}

                        <div class="col-lg-8 offset-lg-2 col-md-12" v-for="offer in offers" style="margin-bottom: 1rem; padding-right: 2rem; padding-left: 2rem;">
                    <div class="card" data-toggle="modal" data-target="#jobModal" style="cursor: pointer;" @click="show(offer)">
                        <div class="card-body" style="padding: 0.6rem !important">
                            <div class="row">
                                <div class="col-3">
                                    <p class="text-center">
                                        <img class="round-img" :src="offer.user.image" alt="Card image" style="width: 75px;">
                                    </p>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title" style="text-transform: capitalize;">@{{ offer.title.toLowerCase() }}</h5>
                                    <small class="text-b" style="text-transform: capitalize;">@{{ offer.job_position.toLowerCase() }}</small><br>
                                    <small class="text-b">@{{ offer.region.name }}, @{{ offer.commune.name }}<span v-if="offer.address">, @{{ offer.address }}</span></small>
                                    <p class="price-op" v-if="offer.wage_type == 1">
                                        $ @{{ parseInt(offer.min_wage).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }} @{{ offer.extra_wage }}
                                    </p>
                                    <p class="price-op" v-else>
                                        A convenir
                                    </p>
                                    <p v-if="offer.is_highlighted == 1">
                                        <strong>Aviso destacado</strong>
                                    </p>
  
                                    <small style="float:right">@{{ dateFormatter(offer.created_at) }}</small>
                                </div>
                            
                            </div>

                        </div>
                    </div>
                        </div>

                        <div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <img :src="image" alt="" style="width: 120px">
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="price-op" v-if="wageType == 1">
                                            $ @{{ parseInt(minWage).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }} @{{ extraWage }}
                                        </p>
                                        <p class="price-op" v-else>
                                            A convenir
                                    </p>
                                    </div>
                                    <div class="col-12">
                                        <p>
                                            <strong>Titulo: </strong> @{{ title }}
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p>
                                            <strong>Categoría: </strong> @{{ category }}
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p>
                                            <strong>Puesto: </strong> @{{ jobPosition }}
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p>
                                            <strong>Descripción: </strong> 
                                        </p>
                                        <div v-html="description" id="description"> </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-center">
                                            <a :href="https://app.encontretrabajo.cl/offers/detail/'+slug" class="btn btn-primary">Postular </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    @include('partials.ads-sidebar')
                </div>

            </div>

            <div class="row" v-cloak>
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="page > 1">
                                <a class="page-link" href="#" aria-label="Previous" @click="fetch(page -1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li v-for="index in pages" class="page-item" v-if="page == index && index >= page - 3 &&  index < page + 3"><a class="page-link" href="#" @click="fetch(index)">@{{ index }}</a></li>
                            <li class="page-item" v-if="page < pages">
                                <a class="page-link" href="#" aria-label="Next" @click="fetch(page + 3)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>    
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>

    </div>

@endsection

@push("scripts")

    <script>
        const devArea = new Vue({
            el: '#search-dev',
            data() {
                return {
                    jobSearch:"",
                    regionSearch:"",
                    communeSearch:"",
                    categorySearch:"",
                    offers:[],
                    image:"",
                    title:"",
                    wageType:"0",
                    description:"",
                    category:"",
                    minWage:"",
                    maxWage:"",
                    jobPosition:"",
                    extraWage:"",
                    page:1,
                    pages:0
                }
            },
            methods: {

                async communeQuery(){

                    let offersRes = await axios.post("{{ url('/search/commune') }}", {communeSearch: this.communeSearch, page: this.page})
                    if(offersRes.data.success == true){

                        this.offers = offersRes.data.offers
                        this.pages = Math.ceil(offersRes.data.offersCount / offersRes.data.dataAmount)
                        
                    }

                },
                async categoryQuery(){

                    let offersRes = await axios.post("{{ url('/search/category') }}", {categorySearch: this.categorySearch, page: this.page})
                    if(offersRes.data.success == true){

                        this.offers = offersRes.data.offers
                        this.pages = Math.ceil(offersRes.data.offersCount / offersRes.data.dataAmount)
                        
                    }

                },
                show(offer){
                   
                    this.image = offer.user.image
                    this.title = offer.title
                    this.category = offer.category.name
                    this.description = offer.description
                    this.minWage = offer.min_wage
                    this.maxWage = offer.max_wage
                    this.jobPosition = offer.job_position
                    this.slug = offer.slug
                    this.wageType = offer.wage_type
                    this.extraWage = offer.extra_wage
                },
                dateFormatter(date){
                    
                    let year = date.substring(0, 4)
                    let month = date.substring(5, 7)
                    let day = date.substring(8, 10)

                    let hour = date.substring(11, 13)
                    let minute = date.substring(14, 16)

                    return day+"-"+month+"-"+year+" "+hour+":"+minute
                }

            },
            created(){
                
                this.communeSearch = localStorage.getItem("encontre_trabajo_commune_search")
                this.categorySearch = localStorage.getItem("encontre_trabajo_category_search")

                if(this.communeSearch != null){
                    this.communeQuery()
                }else if(this.categorySearch != null){
                    this.categoryQuery()
                }
                
                
            }

        })
    </script>

@endpush
