<?php

Namespace App\Notification;

use App\Models\Student;
use App\Models\User;

class FirebasePushNotification
{
	public static function sendPushNotification($deviceToken,$notificationPayload)
	{
		$headers=[
		'Authorization:key='.env('FIREBASE_SERVER_KEY'),
		'Content-Type:application/json',
		];
		
		$data=[
		'registration_ids'=>$deviceToken,   //'to' changed to 'registration_ids' for send message to multiple user
		'notification'=>$notificationPayload,
		];
		
		$ch=curl_init('https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$response=curl_exec($ch);
		curl_close($ch);
		
		return $response;
	
	}
}