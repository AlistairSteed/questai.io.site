<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Enterprise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(Request $request)
    {        
        $enterprise = Enterprise::findOrFail($request->ent);
        return view('auth.passwords.email', compact('enterprise'));
    }

     /**
     * Send a password reset link to a user.
     *
     * @return string
     */
    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'usemail' => 'required|email',
        ]);

        $user = User::where('usemail',$request->usemail)->first();

        if (is_null($user)) {
            return response()->json(['status' => 'error', 'data' => [], 'message' => 'User not found!'], 200);
        }else{  
            $token = Str::random(64);
            $enterpriseId = Enterprise::findOrFail($user->usenterpriseid);

            DB::table('password_resets')->where('email', $request->usemail)->delete();
    
            DB::table('password_resets')->insert([
                'email' => $request->usemail, 
                'token' => $token, 
                'created_at' => Carbon::now()
                ]);
    
            Mail::send('email.forgetPassword', ['token' => $token,'enterpriseId' =>$enterpriseId], function($message) use($request){
                $message->to($request->usemail);
                $message->subject('Reset Password');
            });

            return response()->json(['status' => 'success', 'data' => [], 'message' => 'We have e-mailed your password reset link!'], 200);
        }
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetForm($token,$enterpriseId) { 
          $enterprise = Enterprise::find($enterpriseId);

        return view('auth.passwords.reset', ['token' => $token,'enterprise' => $enterprise, 'enterpriseId' => $enterpriseId]);
     }
 
     /**
      * Write code on Method
      *
      * @return response()
      */
     public function reset(Request $request)
     {
        try {
            $validator = Validator::make($request->all(), [
             'usemail' => 'required|email|exists:users',
             'password' => 'required|string|min:6|confirmed',
             'password_confirmation' => 'required'
         ]);

         if ($validator->fails()) {            
            return response()->json(['status' => 'error', 'data' => [], 'message' => $validator->errors()->all()], 200);
        }
 
        $updatePassword = DB::table('password_resets')
                            ->where([
                            'email' => $request->usemail, 
                            'token' => $request->token
                            ])
                            ->first();
 
        if(!$updatePassword){             
            return response()->json(['status' => 'error', 'data' => [], 'message' => 'Invalid token!'], 200);
        }
 
        $user = User::where('usemail', $request->usemail)
                    ->update(['ushashpw' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->usemail])->delete();
        
        return response()->json(['status' => 'success', 'data' => [], 'message' => 'Thank you. You have successfully reset your password!'], 200);

        } catch (\Exception $e) {
            Log::info('Reset password error => ' . $e->getMessage() . $e->getFile() . $e->getLine());
            return response()->json(['status' => 'error',
                'message' => $e->getMessage(). $e->getFile() . $e->getLine(),
                'data' => []], 400);
        }
     }

    public function thankYou()
    {
        return view('auth.passwords.thankyou');
    }
}
