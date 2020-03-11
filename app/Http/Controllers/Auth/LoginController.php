<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
 use App\User;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    // public function username()
    //     {
    //         return 'user_name';
    //     }

    public function login(Request $request)
    {
        // $this->validateLogin($request);
         $password = \Hash::make($request->password); 
        //  return $password; 
      
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // return $request->email ;
        $user = User::where('email',$request->email)->first();
        // return $user ;
        if(!$user){
            
            // $request->session()->flash('error', trans('admin.email_notfound'));
            return back()->with('error',trans('admin.email_notfound'));;
        }

        if($user['role'] == 'admin' || $user['role'] == 'hr'  ){
            if($user['status'] == 'active'){
                if ($this->attemptLogin($request)) {
                    $user = $this->guard()->user();
                    $user->generateToken();
                    return redirect('/home');
                }
    
                else
                {    
                    return back()->with('error',trans('admin.password_error'));
                }
            }
            else
                {
                    return back()->with('error',trans('admin.user_notactive'));;
                }
           
        }
       else
		{
			$request->session()->flash('error', trans('admin.inccorrect_information_login'));
            return back()->with('error',trans('admin.allowed_access'));
        }
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }
    // public function logout(Request $request)
    // {
    //     $token = $request->header('access_token');
    //     $user = User::where('access_token',$token)->first();

    //     if ($user) {
    //         $user->access_token = null;
    //         $user->save();
    //     }

    //     return response()->json(['data' => 'User logged out.'], 200);
    // }
}
