<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//use DB;
use Mail;
use Hash;
use Validator;
use Socialite;
use App\shop\Entity\User;

class UserAuthController extends Controller{
    public function signUpPage(){
        $binding=['title' => '註冊',];
        return view('auth.signUp',$binding);
    }

    public  function signInPage(){
        $binding=['title' => '登入',];
        return view('auth.signIn',$binding);
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

    public function signInProcess(){
        //接收資料
        $input=request()->all();

        //驗證規則
        $rules = [
            // Email
            'email'=> [
                'required',
                'max:150',
                'email',
            ],
            // 密碼
            'password' => [
                'required',
                'min:6',
            ],
        ];

        $validator=Validator::make($input,$rules);
        if($validator->fails()){
            return redirect('/user/auth/sign-in')
            ->withErrors($validator)
            ->withInput();
        }

        //啟用紀錄SQL語法
        //DB::enableQueryLog();

        //撈取使用者資料
        $User=User::where('email',$input['email'])->firstOrFail();
        //var_dump(DB::getQueryLog());
        //exit;
        //檢查密碼是否正確
        $is_password_correct=Hash::check($input['password'],$User->password);

        if (!$is_password_correct){
            $error_massage=[
                'msg'=>[
                    '密碼驗證錯誤',
                ],
            ];
            return redirect('user/auth/sign-in')
                ->withErrors($error_massage)
                ->withInput();
        }
        //session記錄會員編號
        session()->put('user_id',$User->id);

        //重新導向到原先使用這造訪頁面，沒有嘗試造訪頁則重新導向回首頁
        return redirect('/user/auth/sign-in');
    }

    public function signOut(){
        //清除session
        session()->forget('user_id');
        return redirect('/user/auth/sign-in');
    }

    //Facebook 登入
    //講義版本有誤
    //改寫
    //https://itsolutionstuff.com/post/laravel-56-login-with-facebook-with-socialiteexample.html
    public function facebookSignInProcess(){
        $redirect_url=env('FB_REDIRECT');

        return Socialite::driver('facebook')->redirect();
    }

    public function facebookSignInCallbackProcess(){
        if (request()->error=='access_denied'){
            throw new Exception('授權失敗，存取錯誤');
        }
        $redirect_url=env('FB_REDIRECT');
        //取得第三方資料
        $FacebookUser=Socialite::driver('facebook')
            ->fields([
                'id',
                'name',
                'email',
                'gender',
                'verified',
                'link',
                'first_name',
                'last_name',
                'locale',
            ])
            ->redirectUrl($redirect_url)->user();

        $facebook_email=$FacebookUser->email;
        if(is_null($facebook_email)){
            throw new Exception('未授權取得使用者Email');
        }
        $facebook_id=$FacebookUser->id;
        $facebook_name=$FacebookUser->name;

        $User=User::where('facebook_id',$facebook_id)->first();

        if(is_null($User)){
            //沒有綁定FB id,透過email尋找是否有此帳號
            $User=User::where('email',$facebook_email)->first();
            if(!is_null($User)){
                $User->facebook_id=$facebook_id;
                $User->save();
            }
        }
        if (is_null($User)){
            // 尚未註冊
            $input = [
                'email'       => $facebook_email,   // Email
                'nickname'    => $facebook_name,    // 暱稱
                'password'    => uniqid(),          // 隨機產生密碼
                'facebook_id' => $facebook_id,      // Facebook ID
                'type'        => 'G',               // 一般使用者
            ];
            // 密碼加密
            $input['password'] = Hash::make($input['password']);
            // 新增會員資料
            $User = User::create($input);

            // 寄送註冊通知信
            /*$mail_binding = [
                'nickname' => $input['nickname'],
                'email' => $input['email'],
            ];

            SendSignUpMailJob::dispatch($mail_binding)
                ->onQueue('high');*/
        }
        session()->put('user_id',$User->id);
        return redirect()->intended('/merchandise');
    }
}