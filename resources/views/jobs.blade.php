@extends('layouts.main')

@push("css")

    <style>
        #description p{
            text-align: left !important;
        }

        #description ul{
            list-style: unset !important;
            padding: revert;
        }

        .jobs-search-btn {
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            border-color: #0284c7;
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(14, 165, 233, 0.2);
        }

        .jobs-search-btn:hover,
        .jobs-search-btn:focus {
            background: linear-gradient(135deg, #0369a1, #0ea5e9);
            border-color: #0369a1;
            color: #ffffff;
        }
    </style>

@endpush

@section('content')

    @include('partials.navbar')

    <div id="search-dev" style="padding-top: 120px;">
    
        <div class="container-fluid">

            <div class="row" v-cloak >   
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4>Búsqueda</h4>
                            <div class="form-group">
                                <label for="search">Búsqueda</label>  
                                <input type="text" class="form-control" id="search" v-model="jobSearch">
                            </div>
                            <div class="form-group">
                                <label for="region">Región</label>  
                                <select class="form-control" id="region" v-model="regionSearch">
                                    <option value="">Seleccione</option>
                                    <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">Categoría</label>  
                                <select class="form-control" id="category" v-model="category">
                                    <option value="">Seleccione</option>
                                    <option :value="jobCategory.id" v-for="jobCategory in categories">@{{ jobCategory.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="business">Empresa</label>  
                                <input type="text" class="form-control" id="business" v-model="business">
                            </div>

                            <p class="text-center">
                                <button class="btn jobs-search-btn" @click="query()">buscar</button>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">

                    <div class="col-md-12" v-if="loading == true">
                        <p class="text-center">
                            Buscando resultados
                        </p>
                    </div>

                    <div class="col-md-12" v-if="loading == false && offers.length == 0">
                        <p class="text-center">
                            No se encontraron resultados
                        </p>
                    </div>

                    <div class="row" v-cloak>
                        <div class="col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" v-if="page > 1">
                                        <a class="page-link" href="#" aria-label="Previous" @click="query(page -1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li v-for="index in pages" class="page-item" v-if="page == index && index >= page - 3 &&  index < page + 3"><a class="page-link" href="#" @click="query(index)">@{{ index }}</a></li>
                                    <li class="page-item" v-if="page < pages">
                                        <a class="page-link" href="#" aria-label="Next" @click="query(page + 3)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="col-12" v-for="offer in offers" style="margin-bottom: 1rem; padding-right: 2rem; padding-left: 2rem;">
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

                                        <small>@{{ offer.viewers_count || 0 }} visualizaciones</small>
                                        <small style="float:right">@{{ dateFormatter(offer.created_at) }}</small>
                                        
                                    </div>
                                    
                                
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row" v-cloak>
                        <div class="col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" v-if="page > 1">
                                        <a class="page-link" href="#" aria-label="Previous" @click="query(page -1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li v-for="index in pages" class="page-item" v-if="page == index && index >= page - 3 &&  index < page + 3"><a class="page-link" href="#" @click="query(index)">@{{ index }}</a></li>
                                    <li class="page-item" v-if="page < pages">
                                        <a class="page-link" href="#" aria-label="Next" @click="query(page + 3)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>    
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>

                <div class="col-md-2">
                    @include('partials.ads-sidebar')
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
                                        <a :href="'https://app.encontretrabajo.cl/offers/detail/'+slug" class="btn btn-primary">Postular </a>
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

@endsection

@push("scripts")

    <script>
        const devArea = new Vue({
            el: '#search-dev',
            data() {
                return {
                    jobSearch:"",
                    regionSearch:"",
                    offers:[],
                    regions:[],
                    categories:[],  
                    category:"",
                    business:"",
                    page:1,
                    pages:0,
                    image:"",
                    title:"",
                    slug:"",
                    wageType:"0",
                    description:"",
                    category:"",
                    minWage:"",
                    extraWage:"",
                    maxWage:"",
                    jobPosition:"",
                    slug:"",
                    categorySearch:"",
                    loading:false

                }
            },
            methods: {

                async show(offer){
              
                    this.image = offer.user.image
                    this.title = offer.title
                    this.category = offer.category.name
                    this.description = offer.description
                    this.minWage = offer.min_wage
                    this.wageType = offer.wage_type
                    this.jobPosition = offer.job_position
                    this.extraWage = offer.extra_wage
                    this.slug = offer.slug

                    try {
                        const response = await axios.post("{{ url('/jobs') }}/" + offer.id + "/view")

                        if (response.data.success) {
                            offer.viewers_count = response.data.viewersCount
                        }
                    } catch (error) {
                        // La oferta sigue siendo visible aunque no se pueda registrar la visualización.
                    }
                },
                fetchRegions(){

                    axios.get("{{ url('/regions/all') }}").then(res => {

                        this.regions = res.data.regions

                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/job-categories/all') }}").then(res => {

                        this.categories = res.data.categories

                    })

                },
                async query(page = 1){
                    this.page = page
                    this.loading = true
                    let offersRes = await axios.post("{{ url('/search') }}", {search: this.jobSearch, region: this.regionSearch, category: this.category, business: this.business, page: this.page})
                    this.loading = false
                    if(offersRes.data.success == true){

                        this.offers = offersRes.data.offers
                        this.pages = Math.ceil(offersRes.data.offersCount / offersRes.data.dataAmount)
                        
                    }

                },
                dateFormatter(date){
                    
                    let year = date.substring(0, 4)
                    let month = date.substring(5, 7)
                    let day = date.substring(8, 10)

                    return day+"-"+month+"-"+year
                }

            },
            created(){
                
                //this.jobs()
                this.fetchRegions()
                this.fetchCategories()

                this.jobSearch = localStorage.getItem("encontre_trabajo_job_search")
                this.regionSearch = localStorage.getItem("encontre_trabajo_region_search")
                this.category = localStorage.getItem("encontre_trabajo_category_search")
                this.categorySearch = this.category
                this.query()
                
            }

        })
    </script>

@endpush
