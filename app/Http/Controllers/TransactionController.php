<?php
namespace App\Http\Controllers;

use App\shop\Entity\Transaction;

class TransactionController extends Controller{
    public function transactionListPage(){
        $user_id=session()->get('user_id');
        $row_per_page=10;
        //撈取商品分頁資料
        $TransactionPaginate=Transaction::OrderBy('created_at','desc')
            ->where('user_id',$user_id)
            ->with('Merchandise')
            ->paginate($row_per_page);
        foreach ($TransactionPaginate as &$transaction){
            if(!is_null($transaction->Merchandise->photo)){
                //設定商品照片網址
                $transaction->Merchandise->photo=url($transaction->Merchandise->photo);
            }
        }
        $binding=[
            'title' => '交易記錄',
            'TransactionPaginate'=>$TransactionPaginate,
        ];

        return view('transaction.listUserTransaction',$binding);
    }
}