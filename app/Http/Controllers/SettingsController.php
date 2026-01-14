<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use App\Enum\UserStatus;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Models\ApiSetting;
<<<<<<< HEAD
use App\Models\Vat;
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f


class SettingsController extends Controller
{
    public function settings(Request $request){
        
        $allapis = ApiSetting::all();
        return view('dashboard.pages.settings.allsettings',compact('allapis'));
    }

<<<<<<< HEAD
    public function Vat(Request $request){
        
        $allvats = Vat::all();
        return view('dashboard.pages.vat',compact('allvats'));
    }

    

=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    public function createsettings(Request $request){

         try{
          
           $api_name = $request->api_name;
           $api_key = $request->api_key;
           $setting = new ApiSetting;
           $setting->api_name = $api_name;
           $setting->api_key = $api_key;
           $setting->status = 1;
           $setting->save();
           return response()->json([
               'success'=> true,
               'msg' => 'Api Created'
           ]); 

        }catch(\Exception $e)
        {
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }
    }

    public function updatesettings(Request $request)
    {

       try{
          
           $api_id = $request->api_id;
           $api_name = $request->api_name;
           $api_key = $request->api_key;
           
           $setting = ApiSetting::find($api_id);
           $setting->id = $api_id;
           $setting->api_name = $api_name;
           $setting->api_key = $api_key;
           $setting->save();
           return response()->json([
               'success'=> true,
               'msg' => 'Api Updated'
           ]); 

        }catch(\Exception $e)
        {
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }

    }
<<<<<<< HEAD

    public function updateVat(Request $request)
    {

       try{
          
           $vat_id = $request->vat_id;
           $vat_name = $request->vat_name;
           $vat_value = $request->vat_value;
           
           $vat = Vat::find($vat_id);
           $vat->name = $vat_name;
           $vat->vat = $vat_value;
           $vat->save();
           return response()->json([
               'success'=> true,
               'msg' => 'Vat Updated'
           ]); 

        }catch(\Exception $e)
        {
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }

    }

    
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
    
    
    public function apiexchangerate(Request $request)
    {
        try{

          $api_id = $request->api_id;
          $api_key = $request->api_key;
          $response = Http::withQueryParameters([
                'app_id' => 'ab47f4d1cbb04a0682bbfa01c3d29f04',
           ])
           ->withoutVerifying()
           ->withOptions(["verify"=>false])
           ->get('https://openexchangerates.org/api/latest.json');
           $ress = $response->body();
           $rr = json_decode($ress);
           $all_rates = $rr->rates;
           foreach($all_rates as $key=>$value){
              DB::table('currency')->where('code',$key)->update(['rate'=>$value,'rate_symbol'=>'USD']);
           }

           return response()->json([
               'success'=> true,
               'msg' => 'Exchange Rate Updated'
           ]); 

        }catch(\Exception $e){
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }
    }
   
    
}
