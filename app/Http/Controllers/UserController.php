<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Enterprise;
use App\Models\UserAccess;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @description: Return users list
     */
    public function index($client_id){
        $client = Client::findOrFailByEncryptedId($client_id);
        $client_id = $client->clid;
        $user = Auth::user();
        $user_id = \Auth::id();    
        return view('users', compact('client_id','client','user_id'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @description: Return all data of user
     */
    public function indexAjax($client_id,$user_id){
        $user = Auth::user();
        try {
            if ($user_id == 40 || ($user_id >= 46 && $user_id <=49)) {
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', '=', 'super');
                })->orwhereHas('roles', function ($query) {
                    $query->where('name', '=', 'admin');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','enterprise');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','client');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','');
                })->get();
            } else if ($user->hasRole(['super'])) {
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', '=', 'admin');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','enterprise');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','client');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','');
                })->get();
            } else if ($user->hasRole(['admin'])) {
                $users = User::whereHas('roles', function($query) {
                    $query->where('name','=','enterprise');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','client');
                })->orWhereHas('roles', function($query) {
                    $query->where('name','=','');
                })->get();
            }

            // $users = User::with(['userAccess' => function ($query1) use ($client_id)  {
            //     $query1->where('uaenterpriseid',enterpriseId())->where('uaclientid',$client_id)->where('uacampaignid',0);
            // }])->where('usclientid', $client_id)->orderBy('usid', 'asc')->get();
        } catch (\Exception $e) {
            Log::info('User setup index error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => $users], 200);
    }
    public function clients(){
        $user = auth()->user();
        if ($user->hasRole(['super','admin','enterprise'])) {
            return view('create_client');
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @description: Store and update user data based on user id
     */
    public function store(Request $request, $client_id){
        try {
            $client = Client::findOrFailByEncryptedId($client_id);
            $client_id = $client->clid;   
            
            $inputs = $request->all();

            if (isset($inputs['id']) && $inputs['id']){
                $validate =  [ "user_email" => "unique:users,usemail," . $inputs['id'] . ",usid" ];
            } else {
                $validate =  [ "user_email" => "unique:users,usemail" ];
            }

            $validator = Validator::make($inputs,$validate);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'data' => [], 'message' => 'Email is already been taken'], 200);
            }


            if (isset($inputs['id']) && $inputs['id']){
                $type = 'update';
                $user = User::findOrFail($inputs['id']);

                $user_data = [
                    'usfirstname' => $inputs['first_name'],
                    'uslastname' => $inputs['last_name'],
                    'usemail' => $inputs['user_email'],
                    'usenterpriseid' => enterpriseId(),
                    'usclientid' => $client_id
                ];

                if (isset($inputs['user_password']) && $inputs['user_password']){
                    $user_data['ushashpw'] = bcrypt($inputs['user_password']);
                }
                $user->update($user_data);

                $useraccess = UserAccess::where('uausid',$inputs['id'])->where('uaenterpriseid',enterpriseId())->where('uaclientid',$client_id)->where('uacampaignid',0);

                if ($useraccess){
                    $useraccess->delete();
                }

                if($request->view_all_campaigns !== null){
                    $user_access_data = [
                        'uausid' => $user->usid,
                        'uaenterpriseid' => enterpriseId(),
                        'uaclientid' => $client_id,
                        'uacampaignid' => 0,
                        'uaaccess' => 2,
                    ];

                    $useraccess = UserAccess::create($user_access_data);
                }
            } else {
                $type = 'store';

                $user_data = [
                    'usfirstname' => $inputs['first_name'],
                    'uslastname' => $inputs['last_name'],
                    'usemail' => $inputs['user_email'],
                    'usenterpriseid' => enterpriseId(),
                    'usclientid' => $client_id,
                    'ushashpw' => bcrypt($inputs['user_password']),
                    'ussusertype' => 3,
                    'ususeraccess' => 2
                ];

                //Email to user
                // Mail::to($inputs['user_email'])->send(new UserRegistrationMail($inputs['first_name'], $inputs['last_name'], $inputs['user_email'], $inputs['user_password'], enterpriseId()));

                $token = Str::random(64);
                $enterpriseId = Enterprise::findOrFail(enterpriseId());

                DB::table('password_resets')->where('email', $request->user_email)->delete();
        
                DB::table('password_resets')->insert([
                    'email' => $request->user_email, 
                    'token' => $token, 
                    'created_at' => Carbon::now()
                    ]);
        
                Mail::send('email.resetPassword', ['token' => $token,'enterpriseId' =>$enterpriseId], function($message) use($request){
                    $message->to($request->user_email);
                    $message->subject('Reset Password');
                });

                $user = User::create($user_data);

                
                if($request->view_all_campaigns !== null){
                    $user_access_data = [
                        'uausid' => $user->usid,
                        'uaenterpriseid' => enterpriseId(),
                        'uaclientid' => $client_id,
                        'uacampaignid' => 0,
                        'uaaccess' => 2,
                    ];

                    $useraccess = UserAccess::create($user_access_data);
                }

            }

        } catch (\Exception $e) {
            Log::info('User setup store error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => $user, 'type' => $type], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @description: Delete user data from database
     */
    public function delete($id){
        try {
            $user = User::find($id);
            if ($user){
                $user->delete();
            }
        } catch (\Exception $e) {
            Log::info('User setup delete error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
        return response()->json(['status' => 'success', 'data' => []], 200);
    }
}
