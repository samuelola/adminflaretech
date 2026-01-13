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
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function allUser(Request $request){

        // this is to check query time
        // DB::enableQueryLog();
        // $users = User::distinct('first_name')->count();
        // $queries = DB::getQueryLog();
        // dd($queries);

        $users = User::distinct('first_name')->count();
        return view("dashboard.pages.users.allusers",compact('users'));
    }

    public function allActiveUser(Request $request){

        $activeusers = User::distinct('first_name')->where('active','Yes')->count();
        return view("dashboard.pages.users.allactiveusers",compact('activeusers'));
    }

    public function allInactiveUser(Request $request){

        // $get_all_users = DB::table("users")->orderBy('id','desc')->paginate(10);
        // $gget_all_users = User::where('active','No')->orderBy('id','desc')->lazy();
        $noactiveusers = User::distinct('first_name')->where('active','No')->count();
        return view("dashboard.pages.users.allinactiveusers",compact('noactiveusers'));
    }

    public function deleteUser(Request $request, $id){
        
        $decrypted = decrypt($id);
        User::find($decrypted)->delete();
        return back();
    }

    public function addNewUser(Request $request){
        $all_countries = DB::table('countries')
                         ->orderBy('id','desc')
                         ->get();
        $languages = DB::table('languages')->get();
        return view("dashboard.pages.users.addnew_user",compact('all_countries','languages'));
    }

    public function allState(Request $request)
    {
        $country_id = $request->country_id;
        $all_states = DB::table('states')
                      ->where('country_code',$country_id)
                      ->orderBy('id','desc')
                      ->get();
        return response([
            'success' => true,
            'data' => $all_states,
        ]);
        
    }

    public function createUser(CreateUserRequest $request,UserService $userservice){
         
        $data = $request->validated();
        $data['active'] = 'Yes';
        $data['deleted'] = 'No';
        $data['albums'] = 0;
        $data['tracks'] = 0;
        $data['role_id'] = UserStatus::User;
        $creatUserService = $userservice->storeUser($data);
        if($creatUserService){
           return redirect()->route('allUser')->with('Success','User Created Successfully');
        }else{
           return redirect()->back()->with('Error','User Created not Successfully'); 
        }
    }


    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function alldeletedUser(Request $request){

        $deleted_users = User::onlyTrashed()->get();
        $alldeletedusers = User::onlyTrashed()->count();
        return view('dashboard.pages.users.deleted_users', compact('deleted_users','alldeletedusers'));
    }

    public function deleted_userCompletely(Request $request)
    {
        
        try{
            $user_id = $request->user_id;
            $user = User::withTrashed()->find($user_id);  
            $user->forceDelete();
            return response()->json([
               'success'=> true,
               'msg' => 'User Deleted Successfully'
            ]); 
        }
        catch(\Exception $e){
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }
    }

    public function restore_userCompletely(Request $request)
    {
        
        
        try{
           $user_id = $request->user_id;
           $user = User::withTrashed()->find($user_id);  
           $user->restore();
           return response()->json([
               'success'=> true,
               'msg' => 'User Restored Successfully'
           ]); 

        }catch(\Exception $e)
        {
           return response()->json([
               'success'=> false,
               'msg' => $e->getMessage()
           ]);
        }
    }
    

    
}
