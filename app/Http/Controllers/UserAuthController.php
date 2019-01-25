<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Mail;
use Hash;
use Validator;
use App\shop\Entity\User;

class UserAuthController extends Controller{
    public function signUpPage(){
        $binding=['title' => '註冊',];
        return view('auth.signUp',$binding);
    }

    public function signUpProcess(){
        //接收資料
        $input=request() ->all();
        $rules = [
            // 暱稱
            'nickname'=> [
                'required',
                'max:50',
            ],
            // Email
            'email'=> [
                'required',
                'max:150',
                'email',
            ],
            // 密碼
            'password' => [
                'required',
                'same:password_confirmation',
                'min:6',
            ],
            // 密碼驗證
            'password_confirmation' => [
                'required',
                'min:6',
            ],
            // 帳號類型
            'type' => [
                'required',
                'in:G,A'
            ],
        ];

        // 驗證資料
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            // 資料驗證錯誤
            return redirect('/user/auth/sign-up')
                ->withErrors($validator)
                ->withInput();
        }
        //密碼加密
        $input['password']=Hash::make($input['password']);
        //新增會員資料
        $User=User::create($input);

        $mail_binding=[
            'nickname' => $input['nickname']
        ];

        Mail::send('email.signUpEmailNotification',$mail_binding,function ($mail) use ($input){
           $mail->to($input['email']);
           $mail->from('powerfisg0813@gmail.com');
           $mail->subject('恭喜註冊Shop Laravel 成功');
        });
        return redirect('/user/auth/sign-in');
    }
}