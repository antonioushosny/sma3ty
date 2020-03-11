<?php
use Illuminate\Support\Facades\Hash;
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

use App\Attendance ;
use App\Change ;
use App\Department ;
use App\Discount;
use App\Doc;
use App\Employee;
use App\Reward;
use App\Task;
use App\User;
use App\Vacation ; 
use App\Mac ; 
use App\PasswordReset ; 

use Carbon\Carbon;
use App\Notifications\Notifications;
use App\Notifications\SendMessages;
use Validator;

use App\Notifications\verify_code;

class ApiController extends Controller
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
    private $objuser;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        date_default_timezone_set('Asia/Kuwait');
        $this->middleware('guest')->except('logout');
    }
    protected function SuccessResponse($message ,$data)
    {
        return response()->json([
            'success' => 1,
            'errors'=>[],
            'message' =>$message,
            'data' => $data,

        ]);
    }
    protected function FailedResponse($message ,$errors)
    {
       
        return response()->json([
            'success' => 0,
            'errors'=>$errors,
            'message' =>$message,
            'data' => null,

        ]);
    }

    protected function LoggedResponse($message )
    {
        return response()->json([
            'success' => -1,
            'errors'=>[],
            'message' =>$message,
            'data' => null,

        ]);
    }

//////////////////////////////////////////////
 
//////////////////////////////////////////////
// login function 
    public function Login(Request $request){
        
        $rules=array(
            "mobile"=>"required",
            "password"=>"required",
            "device_id"=>"required",
            "device_type" => "required",  // 1 for ios , 0 for android  
        );

        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                     'message' => $message
                ];
            }
            $message = 'Login failed' ;
            return  $this->FailedResponse($message , $transformed) ;
 
        }

        $employee = Employee::where('mobile',$request->mobile)->first();
        // return $user;
        if(!$employee){
            $errors = [] ;
            $message = 'Mobile Not Found' ;
            return  $this->FailedResponse($message , $errors) ;
 
        }
        else{
            
            if( $employee->status == 'not_active'  ){
                // $errors[] =[
                //     'message' => trans('api.allowed')
                // ];
                $errors = [] ;
                $message = 'This Account Not Active' ;
                return  $this->FailedResponse($message , $errors) ;
            }
            if (\Hash::check( $request->password,$employee->password)) {
                $employee->generateToken();
                $employee->device_token = $request->device_id ;
                $employee->type = $request->device_type ;
                $employee->save();
                $employee->image = asset('img/').'/'. $employee->image;
                $message = 'Login Successfully' ;
                return  $this->SuccessResponse($message , $employee) ;
            }

            $errors = [] ;
            $message =  'Login failed' ;
            return  $this->FailedResponse($message , $errors) ;
        }

    }
//////////////////////////////////////////////
// editprofile function 
    public function EditProfile(Request $request){
        // return $request ;
         $token = $request->header('token');
        if($token == ''){
 
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
           
        }  
        $user = Employee::where('remember_token',$token)->first();
        if($user){      
            $rules=array(  
                "image" => 'file',
            );
            $user = Employee::where('id',$user->id)->first();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
                $destinationPath = public_path('/img');
                $image->move($destinationPath, $name);
                $user->image   = $name;  
            }
            if($request->password){
                $password = \Hash::make($request->password); 
                $user->password   = $password;  
            }
            $user->save();
            $user->image = asset('img/').'/'. $user->image;
            $message = trans('api.save') ;
            return  $this->SuccessResponse($message , $user) ;

        }
        else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }

    }
///////////////////////////////////////////////////
// logout function 
    public function Logout(Request $request){
        $token = $request->header('token');
        
        $token = $request->header('token');
        if($token == ''){
 
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
           
        }  
        // $token = $request->header('access_token');
        $user = Employee::where('remember_token',$token)->first();
        if ($user) {
            $user->remember_token = null;
            $user->device_token = null;
            $user->save();
              
            $message = trans('api.logout') ;
            return  $this->SuccessResponse($message , $user) ;
          
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }

    }
//////////////////////////////////////////////////
// forget_password function 
    public function ForgetPassword(Request $request){
        $rules['email'] = 'required';
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];

            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
        
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;
        }
        $email = $request->email;
        $user = Employee::where('email',$email)->first();
        if($user){
            $token = rand(100000,999999);
            $PasswordReset = PasswordReset::where('email',$user->email)->first();
            if(!$PasswordReset){
                $PasswordReset = new PasswordReset ;
            }
            $PasswordReset->email = $user->email ;
            $PasswordReset->token = $token ;
            $PasswordReset->save();
            Employee::find($user->id)->notify(new verify_code($token));
            $message = 'A confirmation code has been sent to your email';
            $data = null ;
            return  $this->SuccessResponse($message ,$data) ;
             

        }
        
        $errors[]['message'] = 'Email Not Found';
        $message = trans('api.failed') ;
        return  $this->FailedResponse($message , $errors) ;
        
    }
//////////////////////////////////////////////////
// reset_password function 
    public function ResetPassword(Request $request){
        $code = $request->code;
        $email = $request->email;
        if($code){
            $PasswordReset = PasswordReset::where('token',$code)->where('email',$email)->first();
            if($PasswordReset){
                $user = Employee::where('email',$PasswordReset->email)->first();
            }
            
            else{
                $errors[]['message'] = 'code Not Found';
                $message = trans('api.failed') ;
                return  $this->FailedResponse($message , $errors) ;
                 
            }
            if ($user) {
                if($request->password){
                    $password = \Hash::make($request->password);
                    $user->password = $password ;
                    // $user->generateToken();
                    $user->save();
                    $PasswordReset->delete();
                    $message = trans('api.passwordsucces');
                    $data = null ;
                    return  $this->SuccessResponse($message ,$data) ;

                     
                }
                else{
                  

                    $errors[]['message'] = 'password requird';
                    $message = trans('api.failed') ;
                    return  $this->FailedResponse($message , $errors) ;
                }
            
            //   $mail =  Employee::find($user->id)->notify(new verify_code($user->verify_code ));
            //     return $mail;
                
            }
            $error = trans('api.code_notfound');
            return response()->json([
                'success' => 'failed',
                'errors'  => $error,
                "message"=>trans('api.code_notfound'),
                

            ]);
        }
        $error = trans('api.code_required');
        return response()->json([
            'success' => 'failed',
            'errors'  => $error,
            "message"=>trans('api.code_required'),
        

        ]);
        
    }
/////////////////////////////////////////////////
// RequestVacation function 
    public function RequestVacation(Request $request){
        $rules=array(
            "title"=>"required",
            "from"=>"required",
            "to"=>"required",
            "days"=>"required",
            "type"=>"required",
        );
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;
 
        }
       
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $vacation = new Vacation ;
                $vacation->title = $request->title ;
                $vacation->from = $request->from ;
                $vacation->to = $request->to ;
                $vacation->days = $request->days ;
                $vacation->type = $request->type ;
                $vacation->notes = $request->notes ;
                $vacation->employee_id = $user->id ;
                $vacation->status =  'pending' ;
                $vacation->save();
             
                $type = "vacation";
                // $title1 = "  مستخدم جديد قام بالتسجيل" ;
                $msg =  "new request vacation from ".  $user->name  ;
                
                $admins = User::all(); 
                if(sizeof($admins) > 0){
                    foreach($admins as $admin){
                        $admin->notify(new Notifications($msg,$type ));
                        $device_token = $admin->device_token ;
                        if($device_token){
                            $this->notification($device_token,$msg,$msg);
                            $this->webnotification($device_token,$msg,$msg,$type);
                        }
                    }
                }

                $message = trans('api.save') ;
                return  $this->SuccessResponse($message,$vacation ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// ChangeDepartment function 
    public function ChangeDepartment(Request $request){
        $rules=array(
            "title"=>"required",
            "reason"=>"required",
            "department_id"=>"required"
           
        );
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }
    
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $change = new Change ;
                $change->title = $request->title ;
                $change->reason = $request->reason ;
                $change->department_id = $request->department_id ;
                $change->employee_id = $user->id ;
                $change->status = 'pending' ;
                

                $change->save();
            
                $type = "changedepartment";

                $msg = " new request for change department from ".  $user->name  ;
                
                $admins = User::all(); 
                if(sizeof($admins) > 0){
                    foreach($admins as $admin){
                        $admin->notify(new Notifications($msg,$type ));
                        $device_token = $admin->device_token ;
                        if($device_token){
                            $this->notification($device_token,$msg,$msg);
                            $this->webnotification($device_token,$msg,$msg,$type);
                        }
                    }
                }

                $message = trans('api.save') ;
                return  $this->SuccessResponse($message,$change ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// ChangeMac function 
public function ChangeMac(Request $request){
    $rules=array(
        "mac_address"=>"required",
        "reason"=>"required",
        
    );
    $dt = Carbon::now();
    $date  = date('Y-m-d', strtotime($dt));
    // return $date ;
    //check the validator true or not
    $validator  = \Validator::make($request->all(),$rules);
    if($validator->fails())
    {
        $messages = $validator->messages();
        $transformed = [];
        foreach ($messages->all() as $field => $message) {
            $transformed[] = [
                'message' => $message
            ];
        }
        $message = trans('api.failed') ;
        return  $this->FailedResponse($message , $transformed) ;

    }

    $token = $request->header('token');

    if($token){
        $user = Employee::where('remember_token',$token)->first();
        if($user){
            $mac = new Mac ;
            $mac->mac_address = $request->mac_address ;
            $mac->reason = $request->reason ;
            $mac->employee_id = $user->id ;
            $mac->status = 'pending' ;
            $mac->save();
        
            $type = "mac";
            $msg = " new request for change mac address from ".  $user->name  ;
            
            $admins = User::all(); 
            if(sizeof($admins) > 0){
                foreach($admins as $admin){
                    $admin->notify(new Notifications($msg,$type ));
                    $device_token = $admin->device_token ;
                    if($device_token){
                        $this->notification($device_token,$msg,$msg);
                        $this->webnotification($device_token,$msg,$msg,$type);
                    }
                }
            }

            $message = trans('api.save') ;
            return  $this->SuccessResponse($message,$mac ) ;
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }
        
    }else{
        $message = trans('api.logged_out') ;
        return  $this->LoggedResponse($message ) ;
    }


}
/////////////////////////////////////////////////
// Vacations function 
    public function Vacations(Request $request){
         
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $vacations =  Vacation::where('employee_id',$user->id)->orderBy('id', 'desc')->get();
                $vacationss = [] ;
                $i = 0 ;
                if(sizeof($vacations) > 0){
                    foreach($vacations as $vacation){
                        $vacationss[$i]['title']  = $vacation->title ;
                        $vacationss[$i]['from']  = $vacation->from ;
                        $vacationss[$i]['to']  = $vacation->to ;
                        $vacationss[$i]['days']  = $vacation->days ;
                        $vacationss[$i]['type']  = $vacation->type ;
                        $vacationss[$i]['notes']  = $vacation->notes ;
                        $vacationss[$i]['status']  = $vacation->status ;
                        $i++;
                    }
                }
                $data['vacations'] = $vacationss ;
                $data['annual_vacations '] = $user->annual_vacations  ;
                $data['accidental_vacations'] = $user->accidental_vacations ;
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// Departments function 
    public function Departments(Request $request){
         
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $Departments =  Department::where('status','active')->orderBy('id', 'desc')->get();
                $Departmentss = [] ;
                $i = 0 ;
                if(sizeof($Departments) > 0){
                    foreach($Departments as $Department){
                        $Departmentss[$i]['id']  = $Department->id ;
                        $Departmentss[$i]['title']  = $Department->title ;
                        $Departmentss[$i]['image']  = asset('img/').'/'. $Department->image ;
                        $i++;
                    }
                }
                $data['departmentss'] = $Departmentss ;
                
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// MyTasks function 
    public function MyTasks(Request $request){
            
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $tasks =  Task::where('employee_id',$user->id)->orderBy('id', 'desc')->get();
                $taskss = [] ;
                $i = 0 ;
                if(sizeof($tasks) > 0){
                    foreach($tasks as $task){
                        $taskss[$i]['id']  = $task->id ;
                        $taskss[$i]['title']  = $task->title ;
                        $taskss[$i]['date']  = $task->date ;
                        $taskss[$i]['time']  = $task->time ;
                        $taskss[$i]['project_name']  = $task->project_name ;
                        $taskss[$i]['status']  = $task->status ;
                        $i++;
                    }
                }
                $data['taskss'] = $taskss ;
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// ChangeStatus function 
    public function ChangeStatus(Request $request){
        $rules=array(
            "task_id"=>"required",
            "status"=>"required",
            
        );
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $task = Task::where('id',$request->task_id)->first() ;
                if($task){
                    $task->status = $request->status ;
                    $task->save();

                    $type = "ChangeTaskStatus";
                    $msg = $user->name . " change status for task no  ".  $task->id  ;
                
                    $admins = User::all(); 
                    if(sizeof($admins) > 0){
                        foreach($admins as $admin){
                            $admin->notify(new Notifications($msg,$type ));
                            $device_token = $admin->device_token ;
                            if($device_token){
                                $this->notification($device_token,$msg,$msg);
                                $this->webnotification($device_token,$msg,$msg,$type);
                            }
                        }
                    }
                }

                $message = trans('api.save') ;
                return  $this->SuccessResponse($message,$task ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// TaskByDate function 
    public function TaskByDate(Request $request){
        $rules=array(
            "date"=>"required",
             
        );
      
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }      
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        // return $date ;

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $tasks =  Task::where('employee_id',$user->id)->whereDate('date',$request->date)->orderBy('id', 'desc')->get();
                $taskss = [] ;
                $i = 0 ;
                if(sizeof($tasks) > 0){
                    foreach($tasks as $task){
                        $taskss[$i]['id']  = $task->id ;
                        $taskss[$i]['title']  = $task->title ;
                        $taskss[$i]['date']  = $task->date ;
                        $taskss[$i]['time']  = $task->time ;
                        $taskss[$i]['project_name']  = $task->project_name ;
                        $taskss[$i]['status']  = $task->status ;
                        $i++;
                    }
                }
                $data['taskss'] = $taskss ;
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// Salary function 
    public function Salary(Request $request){
                
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
       
        $month = date('m', strtotime($dt));
        $monthName = date('F', mktime(0, 0, 0, $month, 10));
       
         $year = date('Y', strtotime($dt));
        //  return $month ;
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $rewards =  Reward::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('id', 'desc')->get();
                $sumrewards =  Reward::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('id', 'desc')->sum('amount');
                 $rewardss = [] ;
                $i = 0 ;
                if(sizeof($rewards) > 0){
                    foreach($rewards as $reward){
                        $rewardss[$i]['amount']  = $reward->amount ;
                        $rewardss[$i]['reason']  = $reward->reason ;
                        $rewardss[$i]['created_at']  = $reward->created_at ;
                    
                        $i++;
                    }
                }
                $discounts =  Discount::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('id', 'desc')->get();
                $sumdiscounts =  Discount::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->orderBy('id', 'desc')->sum('amount');
                 $discountss = [] ;
                $i = 0 ;
                if(sizeof($discounts) > 0){
                    foreach($discounts as $discount){
                        $discountss[$i]['amount']  = $discount->amount ;
                        $discountss[$i]['reason']  = $discount->reason ;
                        $discountss[$i]['created_at']  = $discount->created_at ;
                    
                        $i++;
                    }
                }
                $data['month'] = $monthName ;
                $data['rewards'] = $rewardss ;
                $data['discounts'] = $discountss ;
                $data['net_salary'] = $user->net_salary  ;
                $data['cross_salary'] = $user->cross_salary  ;
                $data['insurance '] = $user->insurance  ;
                $data['sumrewards'] = $sumrewards  ;
                $data['sumdiscounts'] = $sumdiscounts  ;
                $data['total_salary'] = $user->net_salary + $sumrewards -  $sumdiscounts ;
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// SalaryForMonth function 
    public function SalaryForMonth(Request $request){
        $rules=array(
            "month"=>"required",
             
        );
      
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }          
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        $monthName = date('F', mktime(0, 0, 0, $request->month, 10));
        $year = date('Y', strtotime($dt));
        //  return $month ;
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $rewards =  Reward::where('employee_id',$user->id)->whereMonth('created_at', '=', $request->month)->whereYear('created_at', '=', $year)->orderBy('id', 'desc')->get();
                $sumrewards =  Reward::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $request->month)->orderBy('id', 'desc')->sum('amount');
                $rewardss = [] ;
                $i = 0 ;
                if(sizeof($rewards) > 0){
                    foreach($rewards as $reward){
                        $rewardss[$i]['amount']  = $reward->amount ;
                        $rewardss[$i]['reason']  = $reward->reason ;
                    
                        $i++;
                    }
                }
                $discounts =  Discount::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $request->month)->orderBy('id', 'desc')->get();
                $sumdiscounts =  Discount::where('employee_id',$user->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $request->month)->orderBy('id', 'desc')->sum('amount');
                $discountss = [] ;
                $i = 0 ;
                if(sizeof($discounts) > 0){
                    foreach($discounts as $discount){
                        $discountss[$i]['amount']  = $discount->amount ;
                        $discountss[$i]['reason']  = $discount->reason ;
                    
                        $i++;
                    }
                }
                $data['month'] = $monthName ;
                $data['rewards'] = $rewardss ;
                $data['discounts'] = $discountss ;
                $data['net_salary'] = $user->net_salary  ;
                $data['cross_salary'] = $user->cross_salary  ;
                $data['insurance '] = $user->insurance  ;
                $data['sumrewards'] = $sumrewards  ;
                $data['sumdiscounts'] = $sumdiscounts  ;
                $data['total_salary'] = $user->net_salary + $sumrewards -  $sumdiscounts ;
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// CheckIn function 
    public function CheckIn(Request $request){
        $rules=array(
            "macAddress"=>"required",
            "lat"=>"required",
            "lng"=>"required",
 
        );
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        // return $time ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }
    
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                if($user->mac_address != $request->macAddress){
                    $errors = [] ;
                    $message = 'Your Mac address is incorrect ' ;
                    return  $this->FailedResponse($message , $errors) ;
        
                }
                $doc = Doc::where('type','about')->first();
                $distance = $this->GetDistance($request->lat,$doc->lat,$request->lng,$doc->lng,'K');
                if($distance <= 0.3){
                    $attend =  Attendance::whereDate('date',$date)->where('employee_id',$user->id)->first() ;
                    if(!$attend){
                        $attend = new Attendance ;
                        $attend->date = $date ;
                        $attend->check_in = $time ;
                        $attend->employee_id = $user->id ;
                        $attend->save();
                    } else{
                        $attend->check_in = $time ;
                        $attend->save();
                    }
                    $type = "attendance";
                     $msg = $user->name . "Make Check In At " .  $time  ;
                    
                    $admins = User::all(); 
                    if(sizeof($admins) > 0){
                        foreach($admins as $admin){
                            $admin->notify(new Notifications($msg,$type ));
                            $device_token = $admin->device_token ;
                            if($device_token){
                                $this->notification($device_token,$msg,$msg);
                                $this->webnotification($device_token,$msg,$msg,$type);
                            }
                        }
                    }
    
                    $message = trans('api.save') ;
                    return  $this->SuccessResponse($message,$attend ) ;
                   
                }else{
                    $errors = [] ;
                    $message = "You must be present at the company's headquarters " ;
                    return  $this->FailedResponse($message , $errors) ;
                }
                 
 
            
               
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// CheckOut function 
    public function CheckOut(Request $request){
        $rules=array(
            "macAddress"=>"required",
            "lat"=>"required",
            "lng"=>"required",

        );
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        $time  = date('H:i:s', strtotime($dt));
        // return $time ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }

        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                if($user->mac_address != $request->macAddress){
                    $errors = [] ;
                    $message = 'Your Mac address is incorrect ' ;
                    return  $this->FailedResponse($message , $errors) ;
        
                }
                $doc = Doc::where('type','about')->first();
                $distance = $this->GetDistance($request->lat,$doc->lat,$request->lng,$doc->lng,'K');
                if($distance <= 0.3){
                    $attend =  Attendance::whereDate('date',$date)->where('employee_id',$user->id)->first() ;
                    if(!$attend){
                        $attend = new Attendance ;
                        $attend->date = $date ;
                        $attend->check_out = $time ;
                        $attend->employee_id = $user->id ;
                        $attend->save();
                    } else{
                        $attend->check_out = $time ;
                        $attend->save();
                    } 	
                    $type = "attendance";
                    $msg = $user->name . "Make Check Out At " .  $time  ;
                    
                    $admins = User::all(); 
                    if(sizeof($admins) > 0){
                        foreach($admins as $admin){
                            $admin->notify(new Notifications($msg,$type ));
                            $device_token = $admin->device_token ;
                            if($device_token){
                                $this->notification($device_token,$msg,$msg);
                                $this->webnotification($device_token,$msg,$msg,$type);
                            }
                        }
                    }

                    $message = trans('api.save') ;
                    return  $this->SuccessResponse($message,$attend ) ;
                
                }else{
                    $errors = [] ;
                    $message = "You must be present at the company's headquarters " ;
                    return  $this->FailedResponse($message , $errors) ;
                }
                

            
            
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }
    }
/////////////////////////////////////////////////
/////////////////////////////////////////////////
// Attendance function 
    public function Attendance(Request $request){
                    
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
    
        $month = date('m', strtotime($dt));
        $monthName = date('F', mktime(0, 0, 0, $month, 10));
    
        $year = date('Y', strtotime($dt));
        //  return $month ;
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $attendances =  Attendance::where('employee_id',$user->id)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->orderBy('id', 'desc')->get();
               
                $attendancess = [] ;
                $i = 0 ;
                if(sizeof($attendances) > 0){
                    foreach($attendances as $attendance){
                        $attendancess[$i]['date']  = $attendance->date ;
                        $attendancess[$i]['check_in']  = $attendance->check_in ;
                        $attendancess[$i]['check_out']  = $attendance->check_out ;
                    
                        $i++;
                    }
                }
                
                
                $data['month'] = $monthName ;
                $data['attendances'] = $attendancess ;
                
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// AttendanceByMonth function 
    public function AttendanceByMonth(Request $request){
        $rules=array(
            "month"=>"required",
             
        );
      
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }            
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));

        $month = $request->month;
        $monthName = date('F', mktime(0, 0, 0, $month, 10));

        $year = date('Y', strtotime($dt));
        //  return $month ;
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $attendances =  Attendance::where('employee_id',$user->id)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->orderBy('id', 'desc')->get();
            
                $attendancess = [] ;
                $i = 0 ;
                if(sizeof($attendances) > 0){
                    foreach($attendances as $attendance){
                        $attendancess[$i]['date']  = $attendance->date ;
                        $attendancess[$i]['check_in']  = $attendance->check_in ;
                        $attendancess[$i]['check_out']  = $attendance->check_out ;
                    
                        $i++;
                    }
                }
                
                
                $data['month'] = $monthName ;
                $data['attendances'] = $attendancess ;
                
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// AttendanceByDate function 
    public function AttendanceByDate(Request $request){
        $rules=array(
            "date"=>"required",
             
        );
      
        // return $date ;
        //check the validator true or not
        $validator  = \Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages = $validator->messages();
            $transformed = [];
            foreach ($messages->all() as $field => $message) {
                $transformed[] = [
                    'message' => $message
                ];
            }
            $message = trans('api.failed') ;
            return  $this->FailedResponse($message , $transformed) ;

        }                  
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
 
        $year = date('Y', strtotime($dt));
        //  return $month ;
        $token = $request->header('token');

        if($token){
            $user = Employee::where('remember_token',$token)->first();
            if($user){
                $attendances =  Attendance::where('employee_id',$user->id)->whereDate('date', $request->date)->orderBy('id', 'desc')->get();
            
                $attendancess = [] ;
                $i = 0 ;
                if(sizeof($attendances) > 0){
                    foreach($attendances as $attendance){
                        $attendancess[$i]['date']  = $attendance->date ;
                        $attendancess[$i]['check_in']  = $attendance->check_in ;
                        $attendancess[$i]['check_out']  = $attendance->check_out ;
                    
                        $i++;
                    }
                }
                
                
                 $data['attendances'] = $attendancess ;
                
            
                $message = trans('api.fetch') ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = trans('api.logged_out') ;
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
///////////////////////////////////////////////////
// count_notification function 
    public function count_notification(Request $request){
         $token = $request->header('token');
          // return $token ;
        if($token == ''){
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }
        $user = Employee::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
             $user->save();
            $count = count($user->unreadnotifications) ;
            // return $count ;

            $message = trans('api.fetch') ;
            return  $this->SuccessResponse($message , $count) ;
             
        }
        else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }

    }
/////////////////////////////////////////////////////////
// get_notification function 
    public function get_notification(Request $request){
         $token = $request->header('token');
        if($token == ''){
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }
        $user = Employee::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
            $notifications = $user->notifications->take(25)  ;
            foreach($user->unreadnotifications as $note){
                $note->markAsRead();
            }
            // return $count ;
            $message = trans('api.fetch') ;
            return  $this->SuccessResponse($message , $notifications) ;
            
        }
        else{
            $message = trans('api.logged_out') ;
            return  $this->LoggedResponse($message ) ;
        }

    }
/////////////////////////////////////////////////////////
 
/////////////////////////////////////////////////



////////////////////////////////////////////////////////
   
}
