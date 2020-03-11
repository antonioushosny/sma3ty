<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
// use App\Reservation ;

class SendMessages extends Notification
{
    use Queueable;

    protected  $post;

    public function __construct($msg, $type,$sender ,$recieve)
    {
        $this->msg = $msg ;
        $this->sender = $sender ;
        $this->recieve = $recieve ;
        $this->type = $type;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {
        return [
            'data' => $this->msg,
            'sender' => $this->sender,
            'recieve' => $this->recieve,
            'type' => $this->type,
        
        ];
        

    }
}
