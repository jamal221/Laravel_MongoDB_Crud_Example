<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userinf;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\ObjectId; // Make sure to include this if you're using the MongoDB library


class mainController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mainDashboard(){
        return view('Layout.main_dashboard');
    }

    public function showPrsInf(){
        $fetched_user=userinf::withTrashed()->get();
        // $fetched_user=json_decode($fetched_user);
        // dd($fetched_user);
        return view('pages.profile.regPersonnel', compact('fetched_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function RegPrsInf(Request $request){
        $validator = Validator::make($request->all(), [
            'NameUser'  =>'required| min:6',
            'UserEmail' => 'required|email|min:5',
            'UserMobile'=>'required| min:10'
        ]);
        if($validator->passes()){
            userinf::create($request->all());
            return back()->with('Transaction_Response_user_add', 'اطلاعات کاربر به طور کامل ثبت شد');
        }else{
            return back()->with('Transaction_Response_user_add_error', 'لطفا ساختار فیلد ها را رعایت فرمایید.');
        }
        
        
    }

    public function updateUserInf(Request $request){
        $userID=$request->userID;
        // dd($request->all());
        $updateData=userinf::where('_id',$userID)
                ->update([
                    'NameUser'=>$request->nameUser,
                    'UserEmail'=>$request->emailUser,
                    'UserMobile'=>$request->mobileUser,
                ]);
        if( $updateData){
            return 123;
        }else{
            return 321;
        }
        
    }

    public function EnableDisableUser(Request $request){
        $userID=$request->userID;
        // dd($request->all());
        $user = userinf::find(new ObjectId($userID));
        try{
            // dd($user->Status);
                $UserStatus=$user->Status;
                if($UserStatus){
                    $UserStatus=0;  
                }else{
                    $UserStatus=1;
                }
                $user->Status = $UserStatus; // Replace with the actual status value you want to set
                $user->save();
                return 123;
        }
        catch(\Exception $e)
        {
              return 321;
        }

        
    }

    public function DeleteUserTemp(Request $request){
        // dd($request->all());
        $userID=$request->userID;
        $user = userinf::find($userID); // Replace with the actual user ID
        // dd($user);
        if($user->delete()){
            return 123;
        }else{
            return 321;
        }
       
    }

    public function RestoreUser(Request $request){
        
        $userID=$request->userID;
        // dd($request->all());
        $restoreData=userinf::withTrashed()
                ->where('_id',$userID)
                ->update([
                    'deleted_at'=>null,
                ]);
        if( $restoreData){
            return 123;
        }else{
            return 321;
        }
    }
    
    public function deletePermanently(Request $request){
        $userID=$request->userID;
        // dd($userID);
        $user = userinf::withTrashed()->findOrFail($userID); // Find the model instance
        // dd($user);
        if( $user->forceDelete()){
            return 123;
        }else{
            return 321;
        }
    }
}
