<?php

namespace App\Http\Controllers;
use App\User;
use App\Doc;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Auth;
use App ;
use App\Department ;
use App\Employee ;

use App\Notifications\Notifications;
use Notification;
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

            $lang = App::getlocale();
            $dt = Carbon::now();
            $date = $dt->toDateString();
            $time  = date('H:i:s', strtotime($dt));
            
            $departments        = Department::count('id');
            $hrs        = User::where('role','hr')->count('id');
            $admins    = User::where('role','admin')->count('id');
            $employees    = Employee::count('id');
      
            $title = 'home' ;

           
            return view('home',compact('lang','title','departments','hrs','admins','employees'));
        
    }

    public function settings($type)
    {
        $lang = App::getlocale();
        if($type == 'about'){
            $title = "AboutUs" ;
            $type = "about" ;
        }
        $data      = Doc::where('type',$type)->first();
        // return $about ;
        return view('settings.add',compact('lang','title','type','data')) ;
    }
    public function add($type){
        $lang = App::getlocale();
        if($type == 'about'){
            $title = "AboutUs" ;
            $type = "about" ;
        }
      
        return view('settings.add',compact('title','lang','type')) ;
    }
    public function edit($type,$id){
        $lang = App::getlocale();
        if($type == 'about'){
            $title = "AboutUs" ;
            $type = "about" ;
        }
      
        $data = Doc::find($id) ;
        return view('settings.add',compact('title','lang','type','data')) ;
    }
    public function store(Request $request)
    {
        $lang = App::getlocale();
        // return $request->desc_en;
        if($request->id ){
            $rules =
            [
                'title'  =>'required|max:190',           
                'type'  =>'required',           
                'lat'  =>'required',           
            ];
            
        }     
    
        else{
            $rules =
            [
                'title'  =>'required|max:190',           
                'type'  =>'required', 
                'lat'  =>'required',           

            ];
        }
        
        
         $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
         }
         
        // return $request ;
        if($request->id ){
            $doc = Doc::find( $request->id );
        }
        else{
            $doc = new Doc ;

        }

        $doc->title          = $request->title ;
        $doc->status        = 'active' ;
        $doc->type        = $request->type ;
     
        $doc->disc        = $request->disc ;
        $doc->lat        = $request->lat ;
        $doc->lng        = $request->lng ;
        $doc->save();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
            $doc->image   = $name;  
        }
        $doc->save();
        // return $doc ;
        $type = $doc->type   ;
        if($type == 'about'){
            $title = "AboutUs" ;
            $type = "about" ;
        }
      
        $data =  $doc ;

        // return view('settings.add',compact('title','lang','type','data')) ;
        return response()->json($doc);

    }

    public function destroy($id)
    {
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $id = Doc::find( $id );
        $id ->delete();
        return response()->json($id);
    }

    public function deleteall(Request $request)
    {
        if($request->ids){
            $ids = Doc::whereIn('id',$request->ids)->delete();
        }
        return response()->json($request->ids);
    }


    public function editprofile(Request $request)
    {
        // return $request ;
        if($request->id ){
            $rules =
            [
                'email'  =>'required|email|max:190',            
            ];
        }     
    
        else{
            $rules =
            [
                //'email'  =>'required|email|unique:users,email|max:190',            
                'password'  =>'required|min:6|max:190',     
  
            ];
        }
        if($request->mobile){
            $rules['mobile'] = "between:8,11" ;
        }
        
         $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
         }

        // return $request ;
         if($request->id ){
            $user = User::find( $request->id );

            if($request->email != $user->email){
                $rules =
                [       
                    'email'  =>'required|email|unique:users,email',     
                ];
                $validator = \Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            }
            
            if ($request->hasFile('image')) {

                $imageName =  $user->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            if($request->password){
                $rules =
                [
                    'password'  =>'min:6',                    
                ];
                $validator = \Validator::make($request->all(), $rules);
                if ($validator->fails()){
                    return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
                $password = \Hash::make($request->password);
                $user->password      = $password ;
            }
         }
         else{
            $user = new User ;
            $password = \Hash::make($request->password);
            $user->password      = $password ;
        }
        
        
         $user->email         = $request->email ;
         $user->mobile        = $request->mobile ;
         $user->save();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
            $user->image   = $name;  
        }

        $user->save();

        $lang = App::getlocale();
        return response()->json($user);

    }

    public function messages()
    {
        $lang = App::getlocale();
        $title = 'messages';
        
        $users = Employee::where('status','active')->get();
        // $users = User::where('role','user')->get();
        return view('messages.index',compact('users','title','lang'));
    }

    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'for' => 'required',
            ]);
            
            
            if($request->for == "all"){
                $employees =  Employee::where('status','active')->get();
            }
            else{
                $employees =  Employee::whereIn('id',$request->ids)->get();
            }
        if(sizeof($employees) > 0){
            
            foreach($employees as $employee){
                if($employee){
                    $msg = $request->message ;
                    $title =  $request->title ;
                    $type = "message";
                    // $msg =  $request->message ;
                    $employee->notify(new Notifications($msg,$type ));
                    $device_id = $employee->device_token;
                    // $title = $request->title ; 
                    if($device_id){
                        $this->notification($device_id,$title,$msg,$type);
                    }
                }
            }
        }
        
        return response()->json([ 'success' => trans('admin.successfully_send'), 'message' => trans('admin.successfully_send')], 200);
        // session()->flash('success', trans('admin.successfully_send'));
        // return redirect()->route('messages');
    }
   
}
