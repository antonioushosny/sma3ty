<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;
class NotificationController extends Controller
{
    public function get(){
        $notifications = Auth::user()->unreadnotifications;
        return $notifications;
    }
}
