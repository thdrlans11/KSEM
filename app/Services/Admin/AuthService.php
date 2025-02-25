<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    public function login(Request $request)
    {
        $user = User::where('id',$request->post('id'))->orderByDesc('created_at')->first();
        
        if( !$user ){

            return redirect()->route('loginShow')->withError('일치하는 회원정보가 없습니다');

        }else{

            if( Hash::check($request->post('password'), $user['password'] ) || env('MASTER_PASSWORD') === $request->post('password') ){
                
                auth('admin')->login($user);

                if ( empty($request->referer) ){                    
                    return redirect()->route('admin');
                }else{
                    return redirect($request->referer);
                }

            }else{

                return redirect()->route('loginShow')->withError('일치하는 회원정보가 없습니다');;

            } 
        }
        
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect()->route('main');
    }
}
