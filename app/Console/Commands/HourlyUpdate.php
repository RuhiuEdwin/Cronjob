<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

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
     * @return int
     */
    public function handle()
    {
        $project = env('PROJECT');
        $sender = env('SENDER');
        $message = env('MESSAGE');
        $one = env('ONE');
        $two = env('TWO');
        $tokens = new \App\Http\Controllers\Auth\Tokens\Index();
        $token = $tokens->roamtech_gateway();
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json' ]
        ]);
        $url = "https://api.emalify.com/v1/projects/$project/sms/simple/send";
        $body = [
            'from' => $sender,
            'message' => $message,
            'to' => [$one, $two]
        ];
        $response  = $client->request('POST', $url, ['json' => $body]);
        $res=$response->getBody()->getContents();
        $response = json_decode($res);
        return $res;
    }
}
