<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use App\Models\Track;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{

    //Alert::success('Success','Welcome '.auth()->user()->first_name );
    
    
    public function showDashboard(Request $request)
    {

        // send testing email to oladele

        // $details = [
        //     'title' => 'Mail from Laravel SMTP Tutorial',
        //     'body' => 'This is a test email sent via SMTP in Laravel.'
        // ];

        // $rr = Mail::to('oladelesamuel48@gmail.com')->send(new TestMail($details));

        // if($rr){
        //    dd('Email sent');
        // }else{
        //     dd('Email not sent');
        // }

        


        
        $baseQuery = DB::table('users');
        $baseQuery1 = DB::table('users')->where('role_id','!=',1);
        $baseSubQuery = DB::table("transactions");
        $get_yearr =  DB::raw('YEAR(join_date)as year');
        $users = (clone $baseQuery)->distinct('first_name')->count();
        $users_count_last_30days = (clone $baseQuery)->where('created_at', '>', now()->subDays(30)->endOfDay())->count();
        $total_subscription = (clone $baseSubQuery)->where('remarks','Subscription Payment')->count();
        $total_subscription_last_30days = (clone $baseSubQuery)
            ->where([
                ['created_at', '>', now()->subDays(30)->startOfDay()],
                ['remarks', '=', 'Subscription Payment'],
            ])
            ->count();      
        
        $total_albums =  (clone($baseQuery))->sum('albums');
        $total_albumss = (int)$total_albums;
        $total_tracks = DB::table("trackdetails")->where(['ReleaseCount'=>0,'ReleaseCount'=>1])->distinct('UserName')->count();
        $total_trackss = (int)$total_tracks;
        $total_labels = DB::table("labeldetails")->count();
        $total_labelss = (int)$total_labels;
        $get_all_users = (clone($baseQuery1))->orderBy('id','desc')->paginate(10);
        // $subscribers = (clone $baseSubQuery)->distinct('email')->orderBy('id','desc')->paginate(10);
        $subscribers = Transaction::where('remarks','Subscription Payment')
                        ->with('user','subscription')->orderBy('id','desc')->paginate(10);
        $plans = DB::table('subscription_plan')->orderBy('id','asc')->paginate(10);
        

        if ($request->ajax()) {
            $view = view('dashboard.pages.data', compact('subscribers'))->render();
            $vieww = view('dashboard.pages.dataa', compact('get_all_users'))->render();
            $viewplan = view('dashboard.pages.dataaplan', compact('plans'))->render();
            return response()->json(['html' => $view,'newhtml'=>$vieww,'newhtmlplan'=>$viewplan]);
        }

        
        $thealbums = $this->search_filter_albums($baseQuery);
        $albumvalue = [];              
            foreach($thealbums as $dd){
                $albumvalue[] = $dd->albums;
        }

        $thetracks = $this->search_filter_tracks($baseQuery); 
        $albumvalue = [];              
            foreach($thealbums as $dd){
                $albumvalue[] = $dd->albums;
        }

        $trackvalue = [];              
            foreach($thetracks as $dd){
                $trackvalue[] = $dd->tracks;
        }
                     
        $theyear = $this->the_year($baseQuery,$get_yearr);
        
         $thelang = DB::table('languages')
        ->get();

        $thecountry = DB::table('countries')
        ->get();

        

        return view('dashboard.pages.home',compact(
            'users',
            'users_count_last_30days',
            'total_subscription',
            'total_subscription_last_30days',
            'total_albumss',
            'total_trackss',
            'total_labelss',
            'get_all_users',
            'subscribers',
            'plans',
            'theyear',
            'albumvalue',
            'trackvalue',
            'thelang',
            'thecountry'
        ));
    }

    public function search_filter_albums($query){

      return (clone $query)
            ->select([
            DB::raw('YEAR(join_date)as year'),
            DB::raw('SUM(albums) as albums'),
            ])
            ->orderBy('year', 'ASC')
            ->groupBy('year')
            ->where(DB::raw('YEAR(join_date)'), '!=', 'null' )
            ->where('active','Yes')
            ->get();
        
    }

    public function search_filter_tracks($query){

      return (clone $query)
            ->select([
            DB::raw('YEAR(join_date)as year'),
            DB::raw('SUM(tracks) as tracks'),
            ])
            ->orderBy('year', 'ASC')
            ->groupBy('year')
            ->where(DB::raw('YEAR(join_date)'), '!=', 'null' )
            ->where('active','Yes')
            ->get();
        
    }

    public function the_year($query,$get_yearr){
        return (clone $query)
                ->select((clone $get_yearr))
                ->orderBy('year', 'ASC')           
                ->groupBy('year')
                ->where(DB::raw('YEAR(join_date)'), '!=', 'null' )
                ->where('active','Yes')
                ->get();
    }

    public function filterInfo(Request $request){

        if($request->has('date_filter_data')){
            $year_data = DB::table('users')
                     ->select([
                       DB::raw('MONTH(join_date)as month'),
                       DB::raw('SUM(albums) as albums'),
                       DB::raw('SUM(tracks) as tracks')
                     ])
                     ->orderBy('month', 'ASC')
                     ->groupBy('month')
                     ->where(DB::raw('YEAR(join_date)'), '=', $request->date_filter_data )
                     ->where('active','Yes')
                     ->get();
            if($year_data){
                 return response()->json(['data' => $year_data,'theyyear'=>$request->date_filter_data]);                
            }      
            
        }
        
        if($request->has('filter_language_data')){
            $lang_data = DB::table('users')
                     ->select([
                       DB::raw('YEAR(join_date)as year'), 
                       DB::raw('SUM(albums) as albums'),
                       DB::raw('SUM(tracks) as tracks')
                     ])
                     ->orderBy('year', 'ASC')
                     ->groupBy('year')
                     ->where('language',$request->filter_language_data)
                     ->where(DB::raw('YEAR(join_date)'), '!=', 'null' )
                     ->where('active','Yes')
                     ->get();
            if($lang_data){
                 return response()->json(['langdata' => $lang_data]);                
            }         
        }

        if($request->has('filter_country_data')){
            $country_data = DB::table('users')
                     ->select([
                       DB::raw('YEAR(join_date)as year'), 
                       DB::raw('SUM(albums) as albums'),
                       DB::raw('SUM(tracks) as tracks')
                     ])
                     ->orderBy('year', 'ASC')
                     ->groupBy('year')
                     ->where('country',$request->filter_country_data)
                     ->where(DB::raw('YEAR(join_date)'), '!=', 'null' )
                     ->where('active','Yes')
                     ->get();
            if($country_data){
                 return response()->json(['countrydata' => $country_data]);                
            }        
        }
       
        
        
    }

    public function analytics(Request $request)
    {
        return view('dashboard.pages.analytics');
    }

    public function profile(Request $request)
    {
        if (Session::has('success')){
            Alert::Success('Success', Session::get('success'));
        }
        return view('dashboard.pages.profile');
    }
    

    public function showDashboardd(Request $request){
        $token = $request->pt;
        $decrypted = Crypt::decryptString($token);
        Session::put('tokken',$decrypted);

       if ($decrypted) {
        $response = Http::withToken($decrypted)->get('http://adminflaretech.test/api/user');
        $loggedUserInfo = $response->body();
        $rel = json_decode($loggedUserInfo);
        $user = User::where('id',$rel->user_details->id)->first();
        Auth::setUser($user);
        return Redirect::to('http://adminflaretech.test/dashboard');
       }

        return Redirect::to('http://authflaretech.test');
    }
    public function logout(Request $request) {
        $rri = Session::get('tokken');
        $decrypted = $rri;
        $response = Http::withToken($decrypted)->post('http://adminflaretech.test/api/logout');
        if($response->successful() == true){
            $request->session()->flush();
            $request->session()->regenerateToken();
            return Redirect::to('http://authflaretech.test');
            // $request->session()->forget('tokken');
        }
       
        
    }

    public function viewDashboard(Request $request, $id){
        
        if (Session::has('success')){
            Alert::Success('Success', Session::get('success'));
        }
        if(empty($permissionedituserPermission)){
           abort(403);
        }
        $decrypted = decrypt($id);
        $user_info = DB::table('users')->where('id',$decrypted)->first();
        return view('dashboard.pages.users.user_info',compact('user_info'));
    }

    public function allTracks(Request $request){
         
         $all_th_tracks = Track::with(['audioFile','participants','release'])
                          ->withCount('audioFile')
                          ->orderBy('id','desc')->paginate(10);
         
         if ($request->ajax()) {
            $viewttracks = view('dashboard.pages.trackspage', compact('all_th_tracks'))->render();
            return response()->json(['htmltracks' => $viewttracks]);
        }
         return view('dashboard.pages.tracks',compact('all_th_tracks'));
    }

    public function viewTracks(Request $request,$id){
         //$track_user_detail = DB::table('tracks')->where('id',$id)->first();
         $track_user_detail = Track::with(['audioFile','participants','release'])->where('id',$id)->first();
         return view('dashboard.pages.track_details',compact('track_user_detail'));
    }

    public function download($id){

    $track = Track::with('audioFile')->findOrFail($id);
    // Example if your audio path is stored in the database
    $filePath = $track->audioFile->path ?? null;

    if (!$filePath) {
        return abort(404, 'File not found');
    }

    // External base URL
    
    $origPath = config('services.external_url.website2');
    $remoteUrl = $origPath.'/storage/'.$filePath;
    
    return redirect()->away($remoteUrl);

   
   }

   public function share($id){
    $track = Track::findOrFail($id);
    return view('dashboard.pages.track_share', compact('track'));
   }

    
}