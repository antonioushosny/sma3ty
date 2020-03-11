<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Notifications\Notifications;
use App\User;
use App\Employee;
use App\Task ;

class Tasks extends Command
{
        // function send notification by Antonious Hosny for hala company 
        protected function notification($device_id ,$title,$msg,$id="0")
        {
            $path_to_fcm='https://fcm.googleapis.com/fcm/send';
    
            $server_key="AAAAEs8lujQ:APA91bEUOyRjSowCPLgsaBGYyygoVlo5FpwEJCFKnnxWgnSJk3orjKIGtTykGJnsHOZrHCKoAdnExLTru_fPnqiSqC323HgwHaFeQFgyoLJ--oSvreM3_v6bsBsRxW7qq1ZLvOgGYlpE";
            $key = $device_id;
            $message = $msg;
            $title = $title ;
            $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');
            $user = User::where('device_token', $device_id)->first();
            if(!$user){
                $user = Employee::where('device_token', $device_id)->first();
            }
            if( $user->type == '1'){
                     $fields = array("to" => $key, "notification"=>  array( "text"=>$message ,"id"=>$id,
                        "title"=>$title,
                        "is_background"=>false,
                        "payload"=>array("my-data-item"=>"my-data-value"),
                        "timestamp"=>date('Y-m-d G:i:s'),
                        'sound' => 'default', 'badge' =>'1'
                       
                        ), "priority" => "high",
                      "data"=>  array( "message"=>$message ,
                                                "id"=>$id,
                                                "notification_type"=>$title,
                                                "is_background"=>false,
                                                "payload"=>array("my-data-item"=>"my-data-value"),
                                                "timestamp"=>date('Y-m-d G:i:s')
                                                )
                        );
            
            }
            else{
                 $fields = array("to" => $key,
                "data"=>  array( "message"=>$message ,
                                    "id"=>$id,
                                    "notification_type"=>$title,
                                    "is_background"=>false,
                                    "payload"=>array("my-data-item"=>"my-data-value"),
                                    "timestamp"=>date('Y-m-d G:i:s')
                                    )
            );
            }
       
           
    
           $payload =json_encode($fields);
    
           $curl_session =curl_init();
    
           curl_setopt($curl_session,CURLOPT_URL, $path_to_fcm);
    
           curl_setopt($curl_session,CURLOPT_POST, true);
    
           curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
    
           curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
    
           curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
    
           curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
    
           curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
    
           $result=curl_exec($curl_session);
    
           curl_close($curl_session);
    
                //   dd($result) ;
        }
        // end send notification 
        protected function webnotification($device_id ,$title,$msg,$type)
        {
            date_default_timezone_set('Africa/Cairo');
            $path_to_fcm='https://fcm.googleapis.com/fcm/send';
    
            $server_key="AAAAEs8lujQ:APA91bEUOyRjSowCPLgsaBGYyygoVlo5FpwEJCFKnnxWgnSJk3orjKIGtTykGJnsHOZrHCKoAdnExLTru_fPnqiSqC323HgwHaFeQFgyoLJ--oSvreM3_v6bsBsRxW7qq1ZLvOgGYlpE";
    
            $key = $device_id; 
            $user = User::where('device_token', $device_id)->first();
            $message = $msg ;
            $title = $title ;
             
            // $message = $msg;
            // $title = $title;
            $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');
            $dt = Carbon::now();
            $date  = date('Y-m-d H:i:s', strtotime($dt));
            $fields =array('to'=>$key,
                'notification' => array("title" => $title,
                "body" => $type  ,
                "click_action"=>"fannie/home",
                "sound"=>"default",
                "icon"=>"fannie/public/images/logo.png" ), 'data' => array('type' => $type ,"title" => $title,
                "message" => $message ,"date" => $date   ),
    
            );
            // dd($fields);
           $payload =json_encode($fields);
    
           $curl_session =curl_init();
    
           curl_setopt($curl_session,CURLOPT_URL, $path_to_fcm);
    
           curl_setopt($curl_session,CURLOPT_POST, true);
    
           curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
    
           curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
    
           curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
    
           curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
    
           curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
    
           $result=curl_exec($curl_session);
    
           curl_close($curl_session);
    
            // dd($result) ;
        }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dt = Carbon::now();
        $date  = date('Y-m-d', strtotime($dt. ' + 3 days'));
        
        // $date  = date('Y-m-d', strtotime($date. ' + 1 days'));
        $tasks = Task::whereDate('date',$date)->where('status','waiting')->with('employee')->get();
        
        foreach($tasks as $task){
            $type = "task";
            $msg =  "3 days have passed on task for ".  $task->employee->name  ;
            $employee = Employee::where('id',$task->employee->id)->first();
            $employee->notify(new Notifications($msg,$type )) ;
                    $device_token = $employee->device_token ;
                    if($device_token){
                        $this->notification($device_token,$msg,$msg);
                        $this->webnotification($device_token,$msg,$msg,$type);
                    }
            $admins = User::all(); 
            if(sizeof($admins) > 0){
                foreach($admins as $admin){
                    $admin->notify(new Notifications($msg,$type )) ;
                    $device_token = $admin->device_token ;
                    if($device_token){
                        $this->notification($device_token,$msg,$msg);
                        $this->webnotification($device_token,$msg,$msg,$type);
                    }
                }
            }
        }

        $this->info('success');
    }
}
