<?php
namespace App\Http\Controllers;

use App\shop\Entity\Merchandise;
use Validator;


class MerchandiseController extends Controller{
    public function merchandiseCreateProcess(){
        // 建立商品基本資訊
        $merchandise_data = [
            'status'          => 'C',   // 建立中
            'name'            => '',    // 商品名稱
            'name_en'         => '',    // 商品英文名稱
            'introduction'    => '',    // 商品介紹
            'introduction_en' => '',    // 商品英文介紹
            'photo'           => null,  // 商品照片
            'price'           => 0,     // 價格
            'remain_count'    => 0,     // 商品剩餘數量
        ];
        $Merchandise = Merchandise::create($merchandise_data);

        // 重新導向至商品編輯頁
        return redirect('/merchandise/' . $Merchandise->id . '/edit');
    }
}