<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\SuperadminInterface;


class UserService implements SuperadminInterface
{

    public function storeUser($storeUser){
        
        $rel = (array)$storeUser;
        $user =  User::create($rel);
        return $user;
        
    }
    public function updatePass($data,$id){

    }
    public function storeSub($data){
        
    }
    
    
}