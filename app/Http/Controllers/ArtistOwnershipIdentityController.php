<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtistOwnerIdentity;
use App\Models\ArtistOwnerSong;
use App\Models\ArtistRoleRight;
use App\Models\ArtistRightsConfirmation;
use App\Models\ArtistOwnershipPayment;
use App\Models\ArtistCatalogOwnershipSubmit;
use App\Models\Country;
use App\Models\User;
use App\Models\RightsConfirmation;
use App\Models\SongContributor;
use Illuminate\Support\Facades\Crypt;
use DB;


class ArtistOwnershipIdentityController extends Controller
{
    
     public function songUpload(){
         
         $get_uploadsongs = ArtistOwnerIdentity::with(['user'])
                                         ->orderBy('id','desc')
                                         ->get();                                
         return view('dashboard.pages.catalog_ownership.index',compact('get_uploadsongs'));
     }

     public function artistSong($id){

        $userid = decrypt($id);
        $artist = ArtistOwnerIdentity::where('user_id', $userid)->first();
        $user = User::where('id',$userid)->first();
        $all_countries = DB::table('countries')->get();
        $user_country = Country::where('iso2', $user->country)->first();
        $banks = DB::table('banks')->get();
        $step2 = null;
        if($artist){
            $step2 = ArtistRoleRight::where('artist_ownership_identity_id', $artist->id)->first();
            $songsOwner = ArtistOwnerSong::where('artist_ownership_identity_id', $artist->id)->get();
            $rights = ArtistRightsConfirmation::where('artist_ownership_identity_id', $artist->id)->first();
            $payment = ArtistOwnershipPayment::where('artist_ownership_identity_id', $artist->id)->first();
            $submission = ArtistCatalogOwnershipSubmit::where('artist_ownership_identity_id', $artist->id)->first();
        }

        $genres = DB::table('genres')->get();
        $musical_roles = DB::table('musical_roles')->select('name')->get();

        return view('dashboard.pages.catalog_ownership.monetize_songs', compact(
            'all_countries','user','user_country','artist','step2',
            'genres','songsOwner','musical_roles','rights','banks',
            'payment','submission'
        ));
          
     }
    
    
}
