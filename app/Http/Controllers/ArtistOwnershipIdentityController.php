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
use App\Services\DSPSubmissionService;


class ArtistOwnershipIdentityController extends Controller
{

    protected $dspService;

    public function __construct(DSPSubmissionService $dspService)
    {
        $this->dspService = $dspService;
    }
    
     public function songUpload(){
        
         $user = auth()->user();
         $get_uploadsongs = ArtistOwnerIdentity::with(['submission'])->where('user_id','!=',$user->id)
            ->where('catalog_status', 'submitted')
            ->latest()
            ->get();                                                                 
         return view('dashboard.pages.catalog_ownership.index',compact('get_uploadsongs'));
     }

     public function artistSong($id){
        
        $catalog_id = decrypt($id);
        $artist = ArtistOwnerIdentity::where('id', $catalog_id)->first();
        $user = User::where('id',$artist->user_id)->first();
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

     public function createMetadata($id){
       
       try{
            $catalog_id = decrypt($id);
            $artist = ArtistOwnerIdentity::where('id', $catalog_id)->first();
            $result = $this->dspService->processSubmission($artist->id);
            return back()->with('success', 'Metadata Created Successfuly');
       }catch(\Exception $e){
           return back()->with('error', $e->getMessage());
       }
       
     }

     public function approve($id)
    {

        $catalog_id = decrypt($id);
        $artist = ArtistOwnerIdentity::where('id', $catalog_id)->first();
        $submission = ArtistCatalogOwnershipSubmit::where([
            'artist_ownership_identity_id' => $artist->id,
        ])->first();
        
        if ($submission->status === 'approved') {
            return back()->with('error', 'Already approved');
        }

        $submission->status = 'approved';
        $submission->approved_at = now();
        $submission->save();

        return back()->with('success', 'Submission approved');
    }

    public function reject($id)
    {

        $catalog_id = decrypt($id);
        $artist = ArtistOwnerIdentity::where('id', $catalog_id)->first();
        $submission = ArtistCatalogOwnershipSubmit::where([
            'artist_ownership_identity_id' => $artist->id,
        ])->first();
        
        if ($submission->status === 'approved') {
            return back()->with('error', 'Already approved');
        }

        $submission->status = 'rejected';
        $submission->rejected_at = now();
        $submission->save();

        return back()->with('success', 'Submission rejected');
    }
    
    
}
