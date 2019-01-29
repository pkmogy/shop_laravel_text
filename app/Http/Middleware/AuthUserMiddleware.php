<?php

namespace App\Http\Middleware;
use App\shop\Entity\User;
use Closure;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //預設不可取
        $is_allow_access=false;
        $user_id=session()->get('user_id');

        if (!is_null($user_id)){
            //session有會員編號，允許存取
                $is_allow_access=true;
        }

        if (!$is_allow_access){
            return redirect()->to('/user/auth/sign-in');
        }
        return $next($request);
    }
}
