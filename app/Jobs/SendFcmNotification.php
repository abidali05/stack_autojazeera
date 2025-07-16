<?php

namespace App\Jobs;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendFcmNotification
{
    public static function sendPriceAlertNotification(array $fcmTokens, array $notificationData)
    {
		if(!empty($fcmTokens) || $fcmTokens != NULL ||  $fcmTokens != 'null'){
        $messaging = app('firebase.messaging');

        $notification = Notification::create()
            ->withTitle($notificationData['title'])
            ->withBody($notificationData['body']);

        $data = [
            'vehicle_id' => $notificationData['vehicle_id'] ?? null,
            'updated_at' => now()->toDateTimeString(),
        ];

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);
if(!empty($fcmTokens) || $fcmTokens != NULL ||  $fcmTokens != 'null'){
         $messaging->sendMulticast($message, $fcmTokens);
}
		}

    }

    public function sendAddwishlistNotification($fcmtoken, $notificationData){
  if (!empty($fcmTokens)) {
        $messaging = app('firebase.messaging');

        $notification = Notification::create()
            ->withTitle($notificationData['title'])
            ->withBody($notificationData['body']);

        $data = [
            'vehicle_id' => $notificationData['vehicle_id'] ?? null,
            'updated_at' => now()->toDateTimeString(),
        ];

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

         $messaging->sendMulticast($message, $fcmtoken);
}

    }
}









// <?php
// namespace App\Jobs;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\Notification;
// use Kreait\Firebase\Messaging;

// class SendFcmNotification implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     protected $fcmTokens;
//     protected $vehicleData;

//     public function __construct(array $fcmTokens, array $vehicleData)
//     {
//         $this->fcmTokens = $fcmTokens;
//         $this->vehicleData = $vehicleData;
//     }

//     public function handle()
//     {
//         $messaging = app('firebase.messaging');

//         $notification = Notification::create()
//             ->withTitle($this->vehicleData['title'])
//             ->withBody($this->vehicleData['body']);


//         $data = [
//             'vehicle_id' => 1,
//             'updated_at' => date('m d Y')
//         ];

//         $message = CloudMessage::new()
//             ->withNotification($notification)
//             ->withData($data);
//         $messaging->sendMulticast($message, $this->fcmTokens);
//     }
// }
