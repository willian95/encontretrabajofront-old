<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Offer;
use App\Ad;

class SearchController extends Controller
{
    function index(){
        return view("search", [
            "ads" => $this->getPageAds(),
        ]);
    }

    function jobs(){
        return view("jobs", [
            "ads" => $this->getPageAds(),
        ]);
    }

    private function getPageAds(){
        return Ad::whereIn("id", [8, 9, 10, 11])->get()->keyBy("id");
    }

    function search(Request $request){

        try{

            $dataAmount = 18;
            $page = max(1, (int) $request->input('page', 1));
            $skip = ($page - 1) * $dataAmount;
            $words = array_values(array_filter(
                array_diff(explode(' ', strtolower((string) $request->input('search', ''))), array('de'))
            ));

            $offersQuery = Offer::has("user")
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString());

            if (count($words)) {
                $offersQuery->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    $query->orWhere('title', "like", "%".$words[$i]."%");
                    $query->orWhere('job_position', "like", "%".$words[$i]."%");
                    $query->orWhere('description', "like", "%".$words[$i]."%");
                }      
                });
            }
            
            if($request->filled('business')){
                $offersQuery->whereHas("user", function($q) use($request){
                    $q->where('business_name', "like", "%".$request->business."%");
                });
            }

            if($request->filled('category')){
                $offersQuery->where("category_id", $request->category);
            }

            if($request->filled('region')){
                $offersQuery->where("region_id", $request->region);
            }

            $offersCount = (clone $offersQuery)->count();
            $offers = $offersQuery->with("user", "region", "commune", "category")
                ->withCount([
                    "viewers",
                    "proposals" => function ($query) {
                        $query->whereNotNull("user_id");
                    },
                ])
                ->orderBy("is_highlighted", "desc")
                ->orderBy("id", "desc")
                ->skip($skip)
                ->take($dataAmount)
                ->get();


            return response()->json(["success" => true, "offers" => $offers, "offersCount" => $offersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Hubo un problema"]);
        }

    }

    function communeSearch(Request $request){

        try{

            $dataAmount = 18;
            $skip = ($request->page - 1) * $dataAmount;

            $offers = Offer::with("user", "commune", "region", "category")->withCount("viewers")->has("user")
            ->where("commune_id", $request->communeSearch)
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("id", "desc")
            ->get();

            $offersCount = Offer::with("user", "commune", "region", "category")->has("user")
            ->whereHas("user", function($query) use($request){

                $query->where("commune_id", $request->communeSearch);

            })
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->orderBy("id", "desc")
            ->count();

            return response()->json(["success" => true, "offers" => $offers, "offersCount" => $offersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Hubo un problema"]);
        }

    }

    function categorySearch(Request $request){

        try{

            $dataAmount = 18;
            $skip = ($request->page - 1) * $dataAmount;

            $offers = Offer::with("user", "commune", "region", "category")->withCount("viewers")->has("user")
            ->where("status", "abierto")
            ->where("category_id", $request->categorySearch)
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->take($dataAmount)
            ->orderBy("is_highlighted", "desc")
            ->orderBy("id", "desc")
            ->get();

            $offersCount = Offer::with("user", "commune", "region", "category")->has("user")
            ->where("category_id", $request->categorySearch)
            ->where("status", "abierto")
            ->whereDate('expiration_date', '>', Carbon::today()->toDateString())
            ->orderBy("is_highlighted", "desc")
            ->orderBy("id", "desc")
            ->count();

            return response()->json(["success" => true, "offers" => $offers, "offersCount" => $offersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Hubo un problema"]);
        }

    }
}
