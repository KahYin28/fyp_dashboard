<?php

namespace App\Http\UpdateSocket;

use Illuminate\Support\Facades\Redis;

//use Response;

class TemperatureUpdate  {

    CONST CHANNEL = 'temperature.update';

    public function __construct($data){
        try{
            $redis = Redis::connection();
//            Redis::publish('temperature.update', json_encode(['foo' => 'bar']));
            $redis->publish(self::CHANNEL, $data);

           //dd($redis);

        }catch (\Exception  $e) { dd($e);
            return true;
        }
    }
}
