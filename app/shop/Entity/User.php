<?php
namespace App\shop\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    //資料表名稱
    protected $table='users';
    //主key
    protected $primaryKey='id';
    //可以大量指定異動
    protected $fillable=[
        "email",
        "password",
        "type",
        "nickname",
    ];
}

