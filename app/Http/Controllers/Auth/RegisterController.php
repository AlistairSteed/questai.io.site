<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Client;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public $ent = '';
   // protected $redirectTo = '/login?ent='.$ent;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        $this->middleware('guest');
        
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

       // $this->guard()->login($user);
    //this commented to avoid register user being auto logged in

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usemail' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'usfirstname' => ['required', 'string', 'max:255'],
            'uslastname' => ['required', 'string', 'max:255'],
            'confirm' => ['required', 'string', 'min:8','same:password'],
            'clemail' => ['required', 'string', 'email', 'max:255'],
            'clname' => ['required', 'string', 'max:255'],
            'clcity' => ['required', 'string', 'max:255'],
            'clcounty' => ['required', 'string', 'max:255'],
            'clpostcode' => ['required', 'string', 'max:12'],
            'cltelno' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {  

    $client = Client::create([
        'clenterpriseid' => $data['usenterpriseid'],
        'clname' => $data['clname'],
        'claddress1' => $data['claddress1'],
        'clcity' => $data['clcity'],
        'clcounty' => $data['clcounty'],
        'clpostcode' => $data['clpostcode'],
        'clcountry' => $data['clcountry'],
        'cltelno' => $data['cltelno'],
        'clemail' => $data['clemail'],
        'clvideo' => $data['clvideo'],
        'clcompanydesc' => $data['clcompanydesc'],
        'clcreatedby' => $data['usemail'],
        'cxlcreatedon' => date("Y-m-d H:i:s"),
    ]);
        $user = User::create([
            'usemail' => $data['usemail'],
            'usfirstname' => $data['usfirstname'],
            'uslastname' => $data['uslastname'],
            'ushashpw' => Hash::make($data['password']),
            'usenterpriseid' => $data['usenterpriseid'],
            'usclientid' =>$client->clid,
        ]);
        $user->assignRole('client');
        $user_access_data = [
            'uausid' => $user->usid,
            'uaenterpriseid' => $data['usenterpriseid'],
            'uaclientid' => $client->clid,
            'uacampaignid' => 0,
            'uaaccess' => 1,
        ];

        $useraccess = UserAccess::create($user_access_data);
        return $user;
    }
    protected function registered(Request $request, $user)
    {
        $request->session()->flash('notification', 'Thank you for registering, you can now log in with the details you provided.');
        return redirect('/login?ent=' . $user->usenterpriseid);
        //we can send users account formation email here or anything we want with users even fire that Registered event created earlier

    }
}
