<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Offer;
use App\Ad;
use App\OfferViewer;

class JobController extends Controller
{

    function index(){
        return view('jobs', [
            'ads' => $this->getPageAds(),
        ]);
    }

    function show($slug){
        $offer = Offer::with(['user', 'region', 'commune', 'category'])
            ->has('user')
            ->where('slug', $slug)
            ->where('status', 'abierto')
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->firstOrFail();

        try {
            OfferViewer::create([
                'offer_id' => $offer->id,
            ]);
        } catch (\Exception $e) {
            // El detalle sigue disponible aunque falle el contador de visualizaciones.
        }

        return view('job-detail', [
            'offer' => $offer,
            'ads' => $this->getPageAds(),
        ]);
    }
    
    function getOffers(Request $request){

        try{

            $dataAmount = 18;
            $page = max(1, (int) $request->input('page', 1));
            $skip = ($page - 1) * $dataAmount;

            $offers = Offer::with("user")->withCount(["viewers", "proposals"])->has("user")
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->orderBy("id", "desc")
            ->skip($skip)
            ->take($dataAmount)
            ->get();

            $offersCount = Offer::with("user")->has("user")
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->count();

            return response()->json(["success" => true, "offers" => $offers, "offersCount" => $offersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Hubo un problema"]);
        }

    }

    function registerView(Offer $offer){

        try {
            OfferViewer::create([
                'offer_id' => $offer->id,
            ]);

            return response()->json([
                'success' => true,
                'viewersCount' => $offer->viewers()->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'No fue posible registrar la visualización',
            ], 500);
        }

    }

    private function getPageAds(){
        return Ad::whereIn('id', [8, 9, 10, 11])->get()->keyBy('id');
    }

}
