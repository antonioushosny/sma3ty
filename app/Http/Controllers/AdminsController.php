<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\User;
use Auth;
use App;
use DB;
class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    
        // if(Auth::user()->role != 'admin' ){
        //     return view('unauthorized',compact('role','admin'));
        // }
        
    }
    public function index()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $title = 'admins';
        $admins = User::where('role','admin')->orderBy('id', 'DESC')->get();
        // return $admins ; 
        return view('admins.index',compact('admins','title','lang'));

    }
    public function add()
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $title = 'admins';
        return view('admins.add',compact('title','lang','roles'));
    }
    public function store(Request $request)
    {
       
        // return $request ;
        if($request->id ){
            $rules =
            [
                'name'  =>'required|max:190',
                'email'  =>'required|email|max:190',            
                'status'  =>'required',   
            ];
            
        }     
    
        else{
            $rules =
            [
                'name'  =>'required|max:190',
                'email'  =>'required|email|unique:users,email|max:190',            
                'password'  =>'required|min:6|max:190',     
                'status'  =>'required',       
            ];
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
        $user->name          = $request->name ;
        $user->email         = $request->email ;
        //  $user->mobile        = $request->mobile ;
        $user->status        = $request->status ;
        $user->role            = 'admin';
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
        $title = 'admins';
        $admins = User::where('role','admin')->orderBy('id', 'DESC')->get();
        return redirect()->route('admins');
        return \Redirect::back();
        return view('admins.index',compact('admins','title','lang'));

        return response()->json($user);
      
      

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $lang = App::getlocale();
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $admin = User::where('id',$id)->orderBy('id', 'DESC')->first();
        if($admin)
        {
            $title = 'admins';
            return view('admins.edit',compact('admin','title','lang'));

        }
        else
        {
            return redirect(url('error'));
        }
    }

    public function update(Request $request, $id)
    {
        if($request->id ){
            $rules =
            [
                'name'  =>'required|max:190',
                'email'  =>'required|email|max:190',            
                'status'  =>'required',   
            ];
            
        }     
    
        else{
            $rules =
            [
                'name'  =>'required|max:190',
                'email'  =>'required|email|unique:users,email|max:190',            
                'password'  =>'required|min:6|max:190',     
                'status'  =>'required',       
            ];
        }
        
        
         $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return \Response::json(array('errors' => $validator->getMessageBag()->toArray()));
         }


        // return $request ;
         if($request->id ){
            $user = User::find( $request->id );
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));
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
            $user->assignRole($request->input('roles'));

        }
        
        
         $user->name          = $request->name ;
         $user->email         = $request->email ;
        //  $user->mobile        = $request->mobile ;
         $user->status        = $request->status ;
         $user->role            = 'admin';
         $user->save();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
            $user->image   = $name;  
        }

        $user->save();

        return response()->json($user);
      
    }

    public function destroy($id)
    {
       
        if(Auth::user()->role != 'admin' ){
            $role = 'admin';
            return view('unauthorized',compact('role','admin'));
        }
        $id = User::find( $id );
        $imageName =  $id->image; 
        \File::delete(public_path(). '/img/' . $imageName);
        $id ->delete();

        session()->flash('alert-danger', trans('admin.record_deleted'));   
        return response()->json($id);
        // return view('admin.index',compact('admins','title'));
    }

    public function deleteall(Request $request)
    {
        
        
        if($request->ids){
            foreach($request->ids as $id){
                $id = User::find($id);
                $imageName =  $id->image; 
                \File::delete(public_path(). '/img/' . $imageName);
            }
            $ids = User::whereIn('id',$request->ids)->delete();
        }
        return response()->json($request->ids);
        session()->flash('alert-danger', trans('admin.record_selected_deleted'));
        return redirect()->route('admins');
      
    }
}
