<?php
namespace App\shop\Entity;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model{
    protected $table="merchandise";

    protected $primaryKey="id";

    protected $fillable=[
        "id",
        "status",
        "name",
        "name_en",
        "introduction",
        "introduction_en",
        "photo",
        'price',
        'remain_count',
    ];
}