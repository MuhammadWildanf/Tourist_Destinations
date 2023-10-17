<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;


    protected $fillable = [
        "wisata",
        "price",
        "openTime",
        "closeTime",
        "access",
        "address",
        "numberPhone",
        "img",
        "region_id",
        "business_id",
        "category_id"
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
