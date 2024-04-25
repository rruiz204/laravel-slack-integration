<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GutsNotification;
use Illuminate\Support\Facades\Notification;

class GutsController extends Controller
{
    public function send(Request $request)
    {
        $message = $request->input('message');

        $notification = new GutsNotification($message);
        Notification::route('slack', '#laravel-integration')->notify($notification);

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
