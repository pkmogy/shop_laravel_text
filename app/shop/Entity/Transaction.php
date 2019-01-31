<?php

namespace App\shop\Entity;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model{
    protected $table = 'transaction';

    protected $primaryKey = 'id';

    protected $fillable = [
        "id",
        "user_id",
        "merchandise_id",
        "price",
        "buy_count",
        "total_price",
    ];
    public function Merchandise(){
        return $this->hasOne('App\shop\Entity\Merchandise','id','merchandise_id');
    }
}