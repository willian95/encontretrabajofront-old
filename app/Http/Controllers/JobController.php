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
    
    function getOffers(Request $request){

        try{

            $dataAmount = 18;
            $skip = ($request->page - 1) * $dataAmount;

            $offers = Offer::with("user")->withCount("viewers")->has("user")
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("id", "desc")
            ->get();

            $offersCount = Offer::with("user")->has("user")
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("id", "desc")
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
