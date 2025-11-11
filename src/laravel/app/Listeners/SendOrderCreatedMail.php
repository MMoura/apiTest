<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedMail implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        $client = $event->order->client;
        if ($client && $client->email) {
            Mail::to($client->email)->send(new OrderCreatedMail($event->order));
        }
    }
}
