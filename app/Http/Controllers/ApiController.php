<?php
use Illuminate\Support\Facades\Hash;
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

use App\Models\Appointment ;
use App\Models\Area ;
use App\Models\Chat ;
use App\Models\City;
use App\Models\Country;
use App\Models\Doc;
use App\Models\DoctorDetail;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PasswordReset ; 
use App\Models\Reservation ; 
use App\Models\Specialties ; 
use App\Models\User ; 

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
    protected $redirectTo = '/';
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
            // "device_type" => "required",  // 1 for ios , 0 for android  
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
            $message = 'فشل في تسجيل الدخول' ;
            return  $this->FailedResponse($message , $transformed) ;
 
        }

        $user = User::where('mobile',$request->mobile)->first();
        // return $user;
        if(!$user){
            $errors = [] ;
            $message = 'الرقم غير موجود' ;
            return  $this->FailedResponse($message , $errors) ;
 
        }
        else{
            if( $user->status == '0'  ){
                $errors = [] ;
                $message = 'هذا الحساب غير مفعل' ;
                return  $this->FailedResponse($message , $errors) ;
            }
            if (\Hash::check( $request->password,$user->password)) {
                $user->generateToken();
                $user->device_token = $request->device_id ;
                $user->type = '0' ;
                $user->save();
                if($user->image){$user->image = asset('img/').'/'. $user->image;}
                $message = 'تم تسجيل الدخول بنجاح' ;
                if($user->role == 'doctor'){
                    $user = User::where('id',$user->id)->with('doctorDetails')->first();
                }
                return  $this->SuccessResponse($message , $user) ;
            }

            $errors = [] ;
            $message =  'فشل في تسجيل الدخول' ;
            return  $this->FailedResponse($message , $errors) ;
        }

    }
//////////////////////////////////////////////
// editprofile function 
    public function Register(Request $request){

    
        $rules = array(  
            "name"  => 'required',
            "mobile"  => 'required|unique:users,mobile',
            "email"  => 'required|email|unique:users,email',
            "image" => 'file',
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
            $message = 'فشل في التسجل ' ;
            return  $this->FailedResponse($message , $transformed) ;
 
        }

        $user = new User;
        $user->name = $request->name; 
        $user->email = $request->email; 
        $user->mobile = $request->mobile; 
        $user->role = 'user'; 
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
         if($user->image){$user->image = asset('img/').'/'. $user->image;}
        
        $message = 'تم التسجيل بنجاح' ;
        return  $this->SuccessResponse($message , $user) ;
 

    }
///////////////////////////////////////////////////
// editprofile function 
    public function EditProfile(Request $request){
        // return $request ;
         $token = $request->header('token');
        if($token == ''){
            $message = trans('تم تسجيل الخروج') ;
            return  $this->LoggedResponse($message ) ;
        }  
        $user = User::where('remember_token',$token)->first();
        if($user){      
            $rules=array(  
                "image" => 'file',
            );
            $user = User::where('id',$user->id)->first();
            $user->name = $request->name; 
            $user->email = $request->email; 
            $user->mobile = $request->mobile; 
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
            if($user->role == 'doctor'){
                $doctorDetail  = DoctorDetail::where('user_id',$user->id)->first();
                $doctorDetail->update($request->all());
            }
            if($user->role == 'doctor'){
                $user = User::where('id',$user->id)->with('doctorDetails')->first();
            }
            if($user->image){$user->image = asset('img/').'/'. $user->image;}
            $message = 'تم تعديل الصفحة الشخصية' ;
            return  $this->SuccessResponse($message , $user) ;

        }
        else{
            $message = 'تم تسجيل الخروج' ;
            return  $this->LoggedResponse($message ) ;
        }

    }
///////////////////////////////////////////////////
// logout function 
    public function Logout(Request $request){        
        $token = $request->header('token');
        if($token == ''){
            $message = 'تم تسجيل الخروج' ;
            return  $this->LoggedResponse($message ) ;
        }  
        // $token = $request->header('access_token');
        $user = User::where('remember_token',$token)->first();
        if ($user) {
            $user->remember_token = null;
            $user->device_token = null;
            $user->save();
            $data = null ;
            $message = 'تم تسجيل الخروج'  ;
            return  $this->SuccessResponse($message , $data) ;
          
        }else{
            $message = 'تم تسجيل الخروج'  ;
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
            $message = 'فشل في التحقق في البيانات';
            return  $this->FailedResponse($message , $transformed) ;
        }
        $email = $request->email;
        $user = User::where('email',$email)->first();
        if($user){
            $token = rand(100000,999999);
            $PasswordReset = PasswordReset::where('email',$user->email)->first();
            if(!$PasswordReset){
                $PasswordReset = new PasswordReset ;
            }
            $PasswordReset->email = $user->email ;
            $PasswordReset->token = $token ;
            $PasswordReset->save();
            User::find($user->id)->notify(new verify_code($token));
            $message = 'تم إرسال رمز التأكيد إلى بريدك الإلكتروني';
            $data = null ;
            return  $this->SuccessResponse($message ,$data) ;
             

        }
        
        $errors[]['message'] = 'البريد الإلكتروني غير موجود';
        $message = 'فشلت العملية' ;
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
                $user = User::where('email',$PasswordReset->email)->first();
            }
            else{
                $errors[]['message'] = "الكود غير موجود";
                $message = 'فشلت العملية' ;
                return  $this->FailedResponse($message , $errors) ;
                 
            }
            if ($user) {
                if($request->password){
                    $password = \Hash::make($request->password);
                    $user->password = $password ;
                    // $user->generateToken();
                    $user->save();
                    $PasswordReset->delete();
                    $message = 'تم تغيير كلمة المرور بنجاح';
                    $data = null ;
                    return  $this->SuccessResponse($message ,$data) ;

                }
                else{
    
                    $errors[]['message'] = 'كلمة المرو مطلوبة ';
                    $message = 'فشلت العملية' ;
                    return  $this->FailedResponse($message , $errors) ;
                }
            
            //   $mail =  user::find($user->id)->notify(new verify_code($user->verify_code ));
            //     return $mail;
                
            }
            $error = "الكود غير موجود";
            return response()->json([
                'success' => 'failed',
                'errors'  => $error,
                "message"=> "الكود غير موجود",
                

            ]);
        }
        $error = "الكود غير موجود";
        return response()->json([
            'success' => 'failed',
            'errors'  => $error,
            "message"=> "الكود غير موجود",
        

        ]);
        
    }
/////////////////////////////////////////////////
// homePage function 
    public function homePage(Request $request){
        $token = $request->header('token');
        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                $Specialties = Specialties::active()->select('id','name')->get() ;
                $countries = Country::active()->select('id','name')->with('cities')->get() ;
                $data = [] ;
                $data['specialties'] = $Specialties ;
                $data['countries'] = $countries ;
              
                $message = 'تم الاحضار بنجاح' ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// Doctors function 
    public function Doctors(Request $request){
        $token = $request->header('token');
        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                $doctor = User::active()->where('role','doctor') ;
                if($request->name){
                    $doctor = $doctor->where('name',"like","%".$request->name."%") ;
                }
               
                if($request->country_id){
                    $country_id = $request->country_id ;;
                    $doctor = $doctor->whereHas('doctorDetails',function($query) use($country_id){
                        $query->where('country_id',$country_id);
                    }) ;
                }
                if($request->city_id){
                    $city_id = $request->city_id ;;
                    $doctor = $doctor->whereHas('doctorDetails',function($query) use($city_id){
                        $query->where('city_id',$city_id);
                    }) ;
                }
                if($request->area_id){
                    $area_id = $request->area_id ;;
                    $doctor = $doctor->whereHas('doctorDetails',function($query) use($area_id){
                        $query->where('area_id',$area_id);
                    }) ;
                }
                $doctor = $doctor->select('id','name','email','mobile')->with('doctorDetails')->first(); 
                
                $message = 'تم الاحضار بنجاح' ;
                return  $this->SuccessResponse($message,$doctor ) ;
                
            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// Appointments function 
    public function Appointments(Request $request){
        $rules=array(
            "doctor_id"=>"required",
            "page"     =>"numeric|min:1"     
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
            $message = 'فشل في التحقق' ;
            return  $this->FailedResponse($message , $transformed) ;

        }
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt));
        if($request->page){
            $start_day = $request->page * 7 - 7 ;
            $date = date('Y-m-d', strtotime($date . ' +'.$start_day.' day'));
        }
        // return $date ;
        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                $doctor = User::where('id',$request->doctor_id)->first() ;
                if($doctor){
                    $data = [];
                    for($i = 0 ; $i < 7 ; $i++){
                        $day  = date('D', strtotime($date . ' +'.$i.' day'));
                        $newdate = date('Y-m-d', strtotime($date . ' +'.$i.' day'));
                        // return $day ;
                        // $reservations
                        $appointments = Appointment::active()->where('doctor_id',$doctor->id)->where('day',$day)->whereDoesntHave('reservation')->select('id','from','to')->get();
                        // $data[$i]['day'] = $day ;
                        $data[$i]['date'] = $newdate ;
                        $data[$i]['appointments'] = $appointments ;
                        // return $date->modify('+1 day') ;
                    }
                    
                    $message = 'تم الاحضار بنجاح';
                    return  $this->SuccessResponse($message,$data ) ;
                }
                $message = 'الدكتور غير موجود' ;
                $transformed = [];

                return  $this->FailedResponse($message , $transformed) ;
            
                
            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// MakeReservations function 
    public function MakeReservations(Request $request){
        $rules=array(
            "appointment_id"=>"required",
            "date"          => 'required',
            
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
            $message = 'فشل في التحقق' ;
            return  $this->FailedResponse($message , $transformed) ;

        }

        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                $appointment = Appointment::where('id',$request->appointment_id)->first() ;
                $reservation = Reservation::where('date',$request->date)->where('appointments_id',$request->appointment_id)->first() ;
                if($reservation){
                    $message =' لقد تم حجز هذا الموعد ' ;
                    $transformed = [];
                    return  $this->FailedResponse($message , $transformed) ;
                }
                if($appointment){
                    $reservation = new Reservation;
                    $reservation->date = $request->date ;
                    $reservation->from = $appointment->from ;
                    $reservation->to = $appointment->to ;
                    $reservation->doctor_id = $appointment->doctor_id ;
                    $reservation->user_id = $user->id ;
                    $reservation->appointments_id = $appointment->id ;
                    $reservation->status = 'pending' ;
                    
                    $reservation->save();

                    $type = "reservation";
                    $msg = $user->name . " قام بحجز موعد جديد بتاريخ  ".  $request->date  ;
                    $doctor = User::where('id',$appointment->doctor_id)->first();
                    if($doctor){

                        $doctor->notify(new Notifications($msg,$type ));
                        $device_token = $doctor->device_token ;
                        if($device_token){
                            $this->notification($device_token,$msg,$msg);
                        }
                    }
                    $message = 'تم حجز الموعد بنجاح' ;
                    return  $this->SuccessResponse($message,$reservation ) ;  
                }
                $message =' حدث خطأ ما ' ;
                $transformed = [];
                return  $this->FailedResponse($message , $transformed) ;
               
                
            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// myReservations function 
    public function myReservations(Request $request){
        $token = $request->header('token');
        $limit = 10;
        if($request->page){
            $page = $request->page * $limit - $limit ;
        }else{
            $page = 0 ;
        }
        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                $reservations = [] ;
                $count_all_reservations = 0 ;
                if($user->role == 'user'){
                    $reservations =  Reservation::where('user_id',$user->id)->skip($page)->limit($limit)->with(['doctor'=>function($query){
                        $query->select('id','name','mobile','email') ;
                    }])->select('id','date','from','to','doctor_id','appointments_id')->orderBy('date', 'desc')->orderBy('created_at','Desc')->get();
                    
                    $count_all_reservations =  Reservation::where('user_id',$user->id)->orderBy('created_at','Desc')->count('id');
                    
                   
                }
                if($user->role == 'doctor'){
                    $reservations =  Reservation::where('doctor_id',$user->id)->skip($page)->limit($limit)->with(['user'=>function($query){
                        $query->select('id','name','mobile','email') ;
                    }])->select('id','date','from','to','user_id','appointments_id')->orderBy('date', 'desc')->orderBy('created_at','Desc')->get();
                    
                    $count_all_reservations =  Reservation::where('doctor_id',$user->id)->orderBy('created_at','Desc')->count('id');
                    
                }
                $data['reservations'] = $reservations ;
                $data['limit'] = $limit ;
                $data['count_all_reservations'] = $count_all_reservations ;
            
                $message = 'تم الاحضار بنجاح'  ;
                return  $this->SuccessResponse($message,$data ) ;
                
            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
/////////////////////////////////////////////////
// MakeReservations function 
    public function SendMessage(Request $request){
        $rules=array(
            "recipient_id"=>"required",
            "message"       => 'required',
            
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
            $message = 'فشل في التحقق' ;
            return  $this->FailedResponse($message , $transformed) ;

        }

        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                if($user->role == 'user'){
                   
                    $chat = Chat::where('user_id',$user->id)->where('doctor_id',$request->recipient_id)->first() ;
                    if(!$chat){
                        $chat = new Chat ;
                        $chat->doctor_id = $request->recipient_id ;
                        $chat->user_id   = $user->id ;
                        $chat->save();
                    }

                    $message                = new Message ;
                    $message->chat_id       = $chat->id ; 
                    $message->sender_id     = $user->id ; 
                    $message->recipient_id  = $request->recipient_id ; 
                    $message->text          = $request->message ;
                    $message->type          = 'user' ;
                    $message->status        = 'new';
                    $message->save();
                }
                else{
                    // $recipient = User::where('id',$request->recipient_id)->first();
                    $chat = Chat::where('doctor_id',$user->id)->where('user_id',$request->recipient_id)->first() ;
                    if(!$chat){
                        $chat               = new Chat ;
                        $chat->user_id      = $request->recipient_id ;
                        $chat->doctor_id    = $user->id ;
                        $chat->save();
                    }

                    $message                = new Message ;
                    $message->chat_id       = $chat->id ; 
                    $message->sender_id     = $user->id ; 
                    $message->recipient_id  = $request->recipient_id ; 
                    $message->text          = $request->message ;
                    $message->type          = 'doctor' ;
                    $message->status        = 'new';
                    $message->save();
                }
                $recipient = User::where('id',$request->recipient_id)->first();
                $type = "message";
                $msg = $user->name . "ارسل رسالة جديدة لك "  ;
                if($recipient){

                    $recipient->notify(new Notifications($msg,$type ));
                    $device_token = $recipient->device_token ;
                    if($device_token){
                        $this->notification($device_token,$msg,$msg);
                    }
                }
                $msg = 'تم ارسال الرسالة بنجاح' ;
                return  $this->SuccessResponse($msg,$message ) ;  

            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
///////////////////////////////////////////////
// Chats function 
    public function Chats(Request $request){

        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
                if($user->role == 'user'){
                
                    $chats = Chat::where('user_id',$user->id)->with(['doctor'=>function($query){
                        $query->select('id','name','mobile','email') ;
                    }])->select('id','user_id','doctor_id','created_at')->get() ;
                    
                }
                else{
                    // $recipient = User::where('id',$request->recipient_id)->first();
                    $chats = Chat::where('doctor_id',$user->id)->with(['user'=>function($query){
                        $query->select('id','name','mobile','email') ;
                    }])->select('id','user_id','doctor_id','created_at')->get() ;

                    
                }
                
                $msg = 'تم الاحضار بنجاح' ;
                return  $this->SuccessResponse($msg,$chats ) ;  

            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
///////////////////////////////////////////////
// Messages function 
    public function Messages(Request $request){
        $rules=array(
            "chat_id"=>"required",
            
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
            $message = 'فشل في التحقق' ;
            return  $this->FailedResponse($message , $transformed) ;

        }
        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
            
                $messages = Message::where('chat_id',$request->chat_id)->with(['sender'=>function($query){
                    $query->select('id','name') ;
                }])->with(['recipient'=>function($query){
                    $query->select('id','name') ;
                }])->orderBy('created_at','desc')->get() ;
                
                $msg = 'تم الاحضار بنجاح' ;
                return  $this->SuccessResponse($msg,$messages ) ;  

            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
///////////////////////////////////////////////
// AboutUs function 
    public function AboutUs(Request $request){
        
        $token = $request->header('token');

        if($token){
            $user = user::where('remember_token',$token)->first();
            if($user){
            
                $about = Doc::where('type','about')->select('title','disc')->first() ;
                
                $msg = 'تم الاحضار بنجاح' ;
                return  $this->SuccessResponse($msg,$about ) ;  

            }else{
                $message = 'تم تسجيل الخروج';
                return  $this->LoggedResponse($message ) ;
            }
            
        }else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }


    }
///////////////////////////////////////////////
///////////////////////////////////////////////////
// count_notification function 
    public function count_notification(Request $request){
         $token = $request->header('token');
          // return $token ;
        if($token == ''){
            $message = 'تم تسجيل الخروج' ;
            return  $this->LoggedResponse($message ) ;
        }
        $user = user::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
             $user->save();
            $count = count($user->unreadnotifications) ;
            // return $count ;

            $message = 'تم الاحضار بنجاح' ;
            return  $this->SuccessResponse($message , $count) ;
             
        }
        else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }

    }
/////////////////////////////////////////////////////////
// get_notification function 
    public function get_notification(Request $request){
         $token = $request->header('token');
        if($token == ''){
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }
        $user = user::where('remember_token',$token)->first();
        // $user->notify(new Notifications());
        // return $user ;
        if($user){
            $notifications = $user->notifications->take(25)  ;
            foreach($user->unreadnotifications as $note){
                $note->markAsRead();
            }
            // return $count ;
            $message = 'تم الاحضار بنجاح'  ;
            return  $this->SuccessResponse($message , $notifications) ;
            
        }
        else{
            $message = 'تم تسجيل الخروج';
            return  $this->LoggedResponse($message ) ;
        }

    }
/////////////////////////////////////////////////////////
 
////////////////////////////////////////////////////////
   
}
