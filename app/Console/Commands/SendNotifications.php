<?php

namespace App\Console\Commands;

use App\Mail\CertificateExpiration;
use App\Models\SubscriberCertificateNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $notifications = SubscriberCertificateNotification::whereDate('event_time', $today)->get();
        foreach ($notifications as $notification){
            Mail::to($notification->subscriber->email)->send(new CertificateExpiration($notification));
        }
    }
}