<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Offer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $featuredOffers = Offer::with(['region', 'category'])
        ->has('user')
        ->where('status', 'abierto')
        ->where('is_highlighted', 1)
        ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
        ->orderBy('id', 'desc')
        ->take(3)
        ->get();

    return view('welcome', [
        'featuredOffers' => $featuredOffers,
    ]);
});

Route::get('/auth/google', 'GoogleAuthController@redirect')
    ->middleware('guest')
    ->name('google.redirect');
Route::get('/auth/google/callback', 'GoogleAuthController@callback')
    ->middleware('guest')
    ->name('google.callback');

Route::get('/offers/create', 'OfferController@create')->name('offers.create');
Route::post('/offers', 'OfferController@store')->name('offers.store');

Route::get('/recruitment', function () {
    return view('recruitment');
});

Route::get("/search", "SearchController@index");
Route::get("/jobs", "SearchController@jobs");
Route::post("/search", "SearchController@search");

Route::post("/search/commune", "SearchController@communeSearch");
Route::post("/search/category", "SearchController@categorySearch");

Route::get("/jobs", "JobController@index");
Route::get("/jobs/{slug}", "JobController@show");
Route::post("/jobs", "JobController@getOffers");
Route::post("/jobs/{offer}/view", "JobController@registerView");

Route::get("/regions/all", "RegionController@fetch");

Route::get("/communes/{id}", "RegionController@fetchCommune");

Route::get("/job-categories/all", "JobCategoryController@fetch");

Route::get("quienes-somos", function(){

    $aboutUs = App\AboutUs::first();
    return view("aboutUs", ["image" => $aboutUs->image, "text" => $aboutUs->text, "text2" => $aboutUs->text2]);

});

Route::get("noticia/{slug}", "NewsController@show");
