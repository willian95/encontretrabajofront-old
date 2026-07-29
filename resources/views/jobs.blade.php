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
                        <a :href="'{{ url('/jobs') }}/' + offer.slug" style="color: inherit; text-decoration: none; display: block;">
                        <div class="card" style="cursor: pointer;">
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
                                        <small class="text-b">@{{ location(offer) }}<span v-if="offer.address">, @{{ offer.address }}</span></small>
                                        
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
                        </a>
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
                    categorySearch:"",
                    loading:false

                }
            },
            methods: {

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
                },
                location(offer){

                    const location = []

                    if (offer.region && offer.region.name) {
                        location.push(offer.region.name)
                    }

                    if (offer.commune && offer.commune.name) {
                        location.push(offer.commune.name)
                    }

                    return location.length ? location.join(", ") : "Ubicación no especificada"
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
