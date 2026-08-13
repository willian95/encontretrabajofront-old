<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $table = "offers";

    protected $fillable = [
        'user_id',
        'title',
        'job_position',
        'description',
        'category_id',
        'region_id',
        'commune_id',
        'address',
        'wage_type',
        'min_wage',
        'max_wage',
        'extra_wage',
        'status',
        'expiration_date',
        'slug',
    ];

    public function viewers(){
        return $this->hasMany(OfferViewer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(JobCategory::class);
    }

    public function commune(){
        return $this->belongsTo(Commune::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

}
