<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Illuminate\Http\Request;
use DB;
use App\User;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        // return $request;
        //some validation
        
        $password = $request->password;
        $tokenData = DB::table('password_resets')
        ->where('email', $request->email)->first();
        // return $tokenData ;
        if($tokenData && \Hash::check( $request->code,$tokenData->token)){

            $user = User::where('email', $tokenData->email)->first();
            if ( !$user ) return redirect()->to('home'); //or wherever you want
    
            $user->password = Hash::make($password);
            $user->save(); //or $user->save();
            DB::table('password_resets')->where('email', $user->email)->delete();
            // Auth::login($user);
            return redirect()->to('login')->with('status',trans('api.passwordsucces'));
            return  redirect()->to('home');
        }else{
            return redirect()->to('login')->with('status',trans('admin.resendlink'));
        }

    }
}
