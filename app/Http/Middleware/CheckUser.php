<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Crypt;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
       $token = $request->pt;
       $decrypted = Crypt::decryptString($token);

       if ($decrypted) {
<<<<<<< HEAD
        $response = Http::withToken($decrypted)->get('http://adminflaretech.test/api/user');
=======
        $response = Http::withToken($decrypted)->get('http://superadmin.test/api/user');
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
        $loggedUserInfo = $response->body();
        $rel = json_decode($loggedUserInfo);
        $user = User::where('id',$rel->user_details->id)->first();
        Auth::setUser($user);
        return $next($request);

       }

<<<<<<< HEAD
        return Redirect::to('http://authflaretech.test');
=======
        return Redirect::to('http://auth.test');
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f

        
        
        
    }
}
