<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GutsNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Models\WorkspaceToken;

class GutsController extends Controller
{
    public function send(Request $request)
    {
        $message = $request->input('message');

        $notification = new GutsNotification($message);
        Notification::route('slack', '#laravel-integration')->notify($notification);

        $tokens = WorkspaceToken::all();
        Log::info($tokens);
        $http = new Client();

        foreach ($tokens as $token) {
            $response = $http->post('https://slack.com/api/chat.postMessage', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token->access_token,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'channel' => $token->channel_id,
                    'text' => $message
                ]
            ]);

            $status_code = $response->getStatusCode();
        }

        return response()->json(['message' => 'Success bro!'], $status_code);
    }

    public function auth(Request $request)
    {
        $code = $request->input('code');
        $client_id = env('SLACK_CLIENT_ID');
        $client_secret = env('SLACK_CLIENT_SECRET');

        $http = new Client();
        $response = $http->post('https://slack.com/api/oauth.v2.access', [
            'form_params' => [
                'code' => $code,
                'client_id' => $client_id,
                'client_secret' => $client_secret
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        Log::info($data);

        $workspace_token = new WorkspaceToken([
            'team_name' => $data['team']['name'],
            'access_token' => $data['access_token'],
            'channel' => $data['incoming_webhook']['channel'],
            'channel_id' => $data['incoming_webhook']['channel_id']
        ]);

        $workspace_token->save();

        return response()->json(['message' => 'Success bro!'], 200);
    }
}
