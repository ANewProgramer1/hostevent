<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminder;

class SendEventReminder extends Command
{
    protected $signature = 'send:eventeHost';
    protected $description = 'Lembrete do seu evento';

    public function handle()
    {
        $events = Event::whereDate('event_date', now()->addDay())->get();

        foreach ($events as $event) {
            Mail::to($event->organizer_email)->send(new EventReminder($event));
            $this->info("Este lembrete foi enviado pelo evento: {$event->nomeEvento}.");
        }

        $this->info('Event reminders sent successfully.');
    }
}
