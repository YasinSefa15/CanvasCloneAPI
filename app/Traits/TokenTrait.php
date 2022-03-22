<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait TokenTrait
{
    public function token(array $config){
        $newToken = Str::random(255);
        $userToken = DB::table('user_tokens')->where(
            ['user_id' => $config['user_id'],
                'device' => $config['device']])
            ->update([
                'token' => $newToken,
                'updated_at' => now()
            ]);
        $userToken ? : DB::table('user_tokens')->insert([
            'user_id' => $config['user_id'],
            'token' => $newToken,
            'device' => $config['device'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return $newToken;
    }
}
