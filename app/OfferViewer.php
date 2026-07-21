<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferViewer extends Model
{
    protected $table = "offer_viewers";
    protected $fillable = ["offer_id"];

    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
