<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferViewer extends Model
{
    protected $table = "offer_viewers";

    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
