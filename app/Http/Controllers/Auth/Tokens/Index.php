<?php

namespace App\Http\Controllers\Auth\Tokens;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Index extends Controller
{
    public function   roamtech_gateway()
    {
        return Cache::remember("api_accesstoken",1400,function (){
            $client = new Client(['headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
            ]);
            $clientID = env('CLIENTID');
            $clientSecret = env('CLIENTSECRET');
            $url = "https://api.emalify.com/v1/oauth/token";
            $body['client_id'] = $clientID;
            $body['client_secret'] = $clientSecret;
            $body['grant_type'] = "client_credentials";
            $res = $client->post($url, ['json' => $body]);
            $res = json_decode($res->getBody()->getContents());
            return $res->access_token;
        });
    }
}
