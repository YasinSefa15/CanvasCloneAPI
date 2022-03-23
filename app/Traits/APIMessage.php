<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait APIMessage
{
    protected $actions = [
        'delete' => 'silme',
        'create' => 'oluşturma',
        'update' => 'güncelleme',
        'read' => 'görüntüleme',
        'view' => 'görüntüleme',
        'download' => 'indirme'
    ];

    public function APIMessage(array $config,string $type = null){
        $type = isset($type) ? $this->actions[$type] : '' ;
        $message =  $this->codes([
            'code' => $config['code'],
            'message' => $config['message'],
            'type' => $type
        ]);
        return $message;
    }

    private function codes(array $config){
        $title = DB::table('module_to_routes')->where('route_name',$config['message'])->first();
        if($title){
            $message = $title->title . " " . ( $config['code'] != 400 ? " işlemi başarılı." : " işlemi başarısız.");
        }
        elseif(!is_null($config['type'])){
            $message = $config['message'] . " " .$config['type'] .( $config['code'] != 400 ? " başarılı." : " başarısız.");
        }
        return $message ?? $config['message'];
    }
}
