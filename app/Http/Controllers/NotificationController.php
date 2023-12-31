<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionNotification;
use App\Models\Certificate;
use App\Models\Subscriber;
use App\Models\SubscriberCertificateNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'days' => 'required|integer',
            'certificate' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json($validator->errors());
        }
        $validated = $validator->validated();

        $subscriber = Subscriber::firstOrCreate([
            "email" => $validated['email']
        ]);
        
        $certificate = Certificate::find($validated['certificate']['id']);

        if (!$certificate){
            $certificate = $validated['certificate'];
            $certificate = Certificate::Create([
                "id" => $certificate['id'],
                "issuer_ca_id" => $certificate['issuer_ca_id'],
                "issuer_name" => $certificate['issuer_name'],
                "common_name" => $certificate['common_name'],
                "name_value" => $certificate['name_value'],
                "entry_timestamp" => $certificate['entry_timestamp'],
                "not_before" => $certificate['not_before'],
                "not_after" => $certificate['not_after'],
                "serial_number" => $certificate['serial_number'],
            ]);
        }

        $notification = SubscriberCertificateNotification::firstOrCreate([
            "certificate_id" => $certificate->id,
            "subscriber_id" => $subscriber->id,
            "event_time" => Carbon::createFromTimestampUTC(strtotime('-'.$validated['days'].'day', strtotime($certificate->not_after)))
        ]);

        Mail::to($subscriber->email)->send(new SubscriptionNotification($subscriber));

        return $notification;
    }

}
