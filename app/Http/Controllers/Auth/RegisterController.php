<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        
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
    {   /*
            protected $fillable = [
        'usid',
        'usemail',
        'usfirstname',
        'uslastname',
        'usenterpriseid',
        'usclientid',
        'ususertype',
        'ushashpw',
        'ususeraccess',
    ];
            'clid',
        'clenterpriseid',
        'clname',
        'claddress1',
        'claddress2',
        'clcity',
        'clcounty',
        'clpostcode',
        'clcountry',
        'cltelno',
        'clemail',
        'clvideo',
        'clcompanydesc',
        'clcreatedby',
        'cxlcreatedon',
        'clupdatedby',
        'clupdatedon',
    */
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
    // print_r($client);
    // die();
        $user = User::create([
            'usemail' => $data['usemail'],
            'usfirstname' => $data['usfirstname'],
            'uslastname' => $data['uslastname'],
            'password' => Hash::make($data['password']),
            'usenterpriseid' => $data['usenterpriseid'],
            'usclientid' =>$client->clid,
        ]);
        $user->assignRole('client');
    }
}
